<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthWSDLController extends Controller
{
    // Método para mostrar la vista (el formulario HTML)
    public function mostrarFormulario()
    {
        return view('home');
    }

    // Método para ejecutar tu código SOAP
    public function procesarLogin(Request $request)
    {
        // Validamos que el usuario no envíe el formulario vacío
        $request->validate([
            'IdUsuario' => 'required',
            'Password'  => 'required'
        ]);

        // ============================
        // WS 1: VALIDAR ACCESO CON CUS        
        // ============================

        $ObjetoAD = new \SoapClient('https://cusxacdi.xoc.uam.mx/ws/ValidaAccesoCuenta_WS.php?wsdl', [
            'trace' => 1,
            'exceptions' => true
        ]);

        $Parametros = array(
            'IdUsuario' => $request->IdUsuario, // <- Dato dinámico del formulario
            'Password'  => $request->Password   // <- Dato dinámico del formulario
        );

        try {
            $Resultado = $ObjetoAD->__soapCall('ValidaAccesoCuenta', $Parametros);

            // Evaluamos el resultado de tu código
            if ($Resultado == 1) {
                // Si es 1, regresamos a la vista con un mensaje de éxito
                 return redirect()->intended('/tickets/create')->with('success', '¡Bienvenido! Has iniciado sesión correctamente.');
                    
            } else {
                // Si es 0 (o cualquier otra cosa), regresamos con un error y mantenemos el IdUsuario escrito
                return back()->with('error', 'No. Económico o NIP incorrectos. Intenta de nuevo.')->withInput(['IdUsuario' => $request->IdUsuario]);
            }

        } catch (\SoapFault $e) {
            // Si el servidor falla
            return back()->with('error', 'Error SOAP: ' . $e->getMessage())->withInput();
        }
    }
}