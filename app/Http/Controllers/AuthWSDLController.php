<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthWSDLController extends Controller
{
    public function mostrarFormulario()
    {
        return view('home');
    }

    public function procesarLogin(Request $request)
    {
        $request->validate([
            'IdUsuario' => 'required',
            'Password'  => 'required'
        ]);

        try {
            // ============================
            // WS 1: VALIDAR ACCESO
            // ============================
            $clienteAuth = new \SoapClient('https://cusxacdi.xoc.uam.mx/ws/ValidaAccesoCuenta_WS.php?wsdl', [
                'trace' => 1,
                'exceptions' => true
            ]);

            $resultadoAuth = $clienteAuth->__soapCall('ValidaAccesoCuenta', [
                'IdUsuario' => $request->IdUsuario,
                'Password'  => $request->Password
            ]);

           if ($resultadoAuth == 1) {
    
                // =====================================
                // WS 2: RECUPERAR INFO
                // =====================================
                $clienteInfo = new \SoapClient('https://cusxacdi.xoc.uam.mx/ws/RecuperaInfoCuenta_WS.php?wsdl', [
                    'trace' => 1,
                    'exceptions' => true
                ]);

                $infoUsuario = $clienteInfo->__soapCall('RecuperaInfoCuenta', [
                    'IdUsuario' => $request->IdUsuario
                ]);

                $datosSeparados = explode('|', $infoUsuario);
                $nombreCompleto = isset($datosSeparados[1]) ? $datosSeparados[1] : 'Usuario UAM';
                $tercerDato     = isset($datosSeparados[2]) ? $datosSeparados[2] : ''; 
                
                // ========================================================
                // OBTENER DETALLES DE EMPLEADO DESDE LA DB DE NÓMINA
                // ========================================================
                $empleado = DB::connection('nomina')
                    ->table('Empleados')
                    ->select('ClavePuesto', 'Pagaduria')
                    ->where('NumeroEconomico', $request->IdUsuario)
                    ->first();

                // Valores por defecto
                $rol = 'usuario'; 
                $idDisSis = null;
                $idCoordinacion = null;
                $idSeccion = null;

                // 1. Prioridad Alta: Buscamos si el número económico está registrado como Administrador (dis_sis)
                // Lo buscamos directamente con $request->IdUsuario por seguridad
                $matchDis = DB::table('dis_sis')
                    ->join('rol', 'dis_sis.id_rol', '=', 'rol.id_rol')
                    ->where('dis_sis.num_economico', $request->IdUsuario)
                    ->select('rol.tipo_rol as nombre_rol', 'dis_sis.id_dis_sis')
                    ->first();

                if ($matchDis) {
                    // Si la DB devuelve 'administrador', lo homologamos a 'admin' para que coincida con tus rutas
                    $rol = ($matchDis->nombre_rol === 'administrador') ? 'admin' : $matchDis->nombre_rol;
                    $idDisSis = $matchDis->id_dis_sis;

                } elseif ($empleado) {
                    
                    // 2. Si no es administrador, buscamos si la combinación existe en Coordinaciones
                    $matchCoord = DB::table('coordinaciones')
                        ->join('rol', 'coordinaciones.id_rol', '=', 'rol.id_rol')
                        ->where('coordinaciones.ClavePuesto', $empleado->ClavePuesto)
                        ->where('coordinaciones.Pagaduria', $empleado->Pagaduria)
                        ->select('rol.tipo_rol as nombre_rol', 'coordinaciones.id_coordinacion')
                        ->first();

                    if ($matchCoord) {
                        $rol = $matchCoord->nombre_rol; // Tomará el valor 'coordinador'
                        $idCoordinacion = $matchCoord->id_coordinacion;
                    } else {
                        
                        // 3. Si tampoco es coordinación, buscamos en la tabla de Secciones
                        $matchSecc = DB::table('secciones')
                            ->join('rol', 'secciones.id_rol', '=', 'rol.id_rol')
                            ->where('secciones.ClavePuesto', $empleado->ClavePuesto)
                            ->where('secciones.Pagaduria', $empleado->Pagaduria)
                            ->select('rol.tipo_rol as nombre_rol', 'secciones.id_seccion')
                            ->first();

                        if ($matchSecc) {
                            $rol = $matchSecc->nombre_rol; // Tomará el valor 'seccion'
                            $idSeccion = $matchSecc->id_seccion;
                        }
                    }
                }

                // Guardamos los datos corregidos en la SESIÓN de Laravel
                session([
                    'usuario_autenticado' => true,
                    'no_economico'        => $request->IdUsuario,
                    'solo_nombre'         => $tercerDato, 
                    'usuario_rol'         => $rol,
                    'id_dis_sis'          => $idDisSis,      // Corregido el string y añadida la coma
                    'id_coordinacion'     => $idCoordinacion, 
                    'id_seccion'          => $idSeccion       
                ]);

                // REDIRECCIÓN DINÁMICA CON CONCATENACIÓN DE VARIABLES REALES
                if ($rol === 'admin') {
                    return redirect()->intended('/tickets/all')->with('success', 'Panel de Administrador.');
                } elseif ($rol === 'coordinador') {
                    return redirect()->intended('/coords/' . $idCoordinacion)->with('success', 'Panel de Coordinación.');
                } elseif ($rol === 'seccion') {
                    return redirect()->intended('/seccs/' . $idSeccion)->with('success', 'Panel de Sección.');
                }

                // Redirección por defecto (Trabajador común)
                return redirect()->intended('/tickets/create')->with('success', '¡Bienvenido ' . $tercerDato . '! Has iniciado sesión correctamente.');
                    
            } else {
                return back()->with('error', 'No. Económico o NIP incorrectos.')->withInput();
            }
                } catch (\SoapFault $e) {
                    return back()->with('error', 'Error en el servidor de identidad: ' . $e->getMessage())->withInput();
                }
            }


    public function destroy(Request $request)
    {
        // Cierra sesión en el Guard de Laravel
        Auth::logout();

        // Borra todos los datos de la sesión actual
        $request->session()->flush(); 

        // Invalida la sesión y regenera el token CSRF para evitar ataques
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir eliminando las cabeceras de caché también en la salida
        return redirect('/')
            ->with('success', 'Has cerrado sesión correctamente.')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
            ]);
    }
}