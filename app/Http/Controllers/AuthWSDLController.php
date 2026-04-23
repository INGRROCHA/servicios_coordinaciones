<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

                // Llamada al Web Service
                $infoUsuario = $clienteInfo->__soapCall('RecuperaInfoCuenta', [
                    'IdUsuario' => $request->IdUsuario
                ]);

                // 1. Separamos la cadena usando el pipeline '|'
                // Suponiendo que $infoUsuario devuelve la cadena directamente, o si viene en un objeto ajusta a $infoUsuario->return
                $datosSeparados = explode('|', $infoUsuario);

                // 2. Extraemos los datos según su posición
                // Validamos que el arreglo tenga suficientes elementos para evitar errores
                $nombreCompleto = isset($datosSeparados[1]) ? $datosSeparados[1] : 'Usuario UAM';
                $tercerDato     = isset($datosSeparados[2]) ? $datosSeparados[2] : ''; // Aquí estará "ROBERTO"
                
                // Guardamos los datos en la SESIÓN de Laravel
                session([
                    'usuario_autenticado' => true,
                    'no_economico'        => $request->IdUsuario,
                    'solo_nombre'         => $tercerDato // Agregamos el tercer dato a la sesión
                ]);

                return redirect()->intended('/tickets/create')->with('success', '¡Bienvenido ' . $tercerDato . '! Has iniciado sesión correctamente.');
                    
            } else {
                return back()->with('error', 'No. Económico o NIP incorrectos.')->withInput();
            }

        } catch (\SoapFault $e) {
            return back()->with('error', 'Error en el servidor de identidad: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy()
    {
        // Limpiamos la sesión manual
        session()->forget(['usuario_autenticado', 'no_economico', 'nombre']);
        Auth::logout();
        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }
}