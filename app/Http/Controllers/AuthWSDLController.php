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
                $idCoordinacion = null;
                $idSeccion = null;

                if ($empleado) {
                    // 1. Buscamos primero si la combinación existe en la tabla de Coordinaciones
                    $matchCoord = DB::table('coordinaciones')
                        ->join('rol', 'coordinaciones.id_rol', '=', 'rol.id_rol')
                        ->where('coordinaciones.ClavePuesto', $empleado->ClavePuesto)
                        ->where('coordinaciones.Pagaduria', $empleado->Pagaduria)
                        ->select('rol.tipo_rol as nombre_rol', 'coordinaciones.id_coordinacion')
                        ->first();

                    if ($matchCoord) {
                        $rol = $matchCoord->nombre_rol; // Tomará valores como 'coordinador'
                        $idCoordinacion = $matchCoord->id_coordinacion;
                    } else {
                        // 2. Si no fue así, buscamos en la tabla de Secciones
                        $matchSecc = DB::table('secciones')
                            ->join('rol', 'secciones.id_rol', '=', 'rol.id_rol')
                            ->where('secciones.ClavePuesto', $empleado->ClavePuesto)
                            ->where('secciones.Pagaduria', $empleado->Pagaduria)
                            ->select('rol.tipo_rol as nombre_rol', 'secciones.id_seccion')
                            ->first();

                        if ($matchSecc) {
                            $rol = $matchSecc->nombre_rol; // Tomará valores como 'seccion'
                            $idSeccion = $matchSecc->id_seccion;
                        }
                    }
                }

                // Guardamos los datos en la SESIÓN de Laravel
                session([
                    'usuario_autenticado' => true,
                    'no_economico'        => $request->IdUsuario,
                    'solo_nombre'         => $tercerDato, // <-- CORREGIDO: Faltaba una coma aquí
                    'usuario_rol'         => $rol,
                    
                    // BONUS: Guardamos los IDs correspondientes en la sesión. 
                    // Esto evitará que tengas que pasarlos por la URL en tus componentes Livewire.
                    'id_coordinacion'     => $idCoordinacion, 
                    'id_seccion'          => $idSeccion       
                ]);

                // REDIRECCIÓN DINÁMICA SEGÚN EL ROL DEVUELTO POR LA BASE DE DATOS
                if ($rol === 'admin') {
                    return redirect()->intended('/admin/dashboard')->with('success', 'Panel de Administrador.');
                } elseif ($rol === 'coordinador') {
                    return redirect()->intended('/tickets/coordinacion')->with('success', 'Panel de Coordinación.');
                } elseif ($rol === 'seccion') {
                    return redirect()->intended('/tickets/seccion')->with('success', 'Panel de Sección.');
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