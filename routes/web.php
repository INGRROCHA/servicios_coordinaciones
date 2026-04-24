<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrearController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EditarController;
use App\Http\Controllers\AuthWSDLController;
use App\Http\Middleware\VerificarSesionUAM;

// ==========================================
// Ruta Pública (No requiere sesión)
// ==========================================

//Autenticación con WSDL al iniciar sesión
Route::get('/', [AuthWSDLController::class, 'mostrarFormulario'])->name('login.uam');
Route::post('/', [AuthWSDLController::class, 'procesarLogin'])->name('login.uam');


// ==========================================
// Rutas Protegidas (Requieren sesión activa)
// ==========================================

Route::middleware([VerificarSesionUAM::class])->group(function () {

    //Levantar un ticket de servicio
    Route::get('/tickets/create', function () {
        return view('tickets.create');
    });
    Route::get('/buscar-usuario/{num_economico}', [CrearController::class, 'buscarPorNomina']);
    Route::post('/guardar-datos-personales', [CrearController::class, 'storeDatosPersonales']);
    Route::post('/tickets', [CrearController::class, 'crear']);

    //Mostrar todos los tickets
    Route::get('/tickets/show/', [ServicioController::class, 'show']);

    //Mostrar ticket por id
    Route::get('/tickets/index', [ConsultaController::class, 'mostrarFormulario'])->name('consultar.form');
    Route::post('tickets.index', [ConsultaController::class, 'buscarTicket'])->name('consultar.buscar');

    //Mostrar ticket por Coordinacion
    Route::get('/coords/{id}', [ServicioController::class, 'ticketsPorCoordinacion']);

    //Mostrar ticket por Seccion
    Route::get('/seccs/{id}', [ServicioController::class, 'ticketsPorSeccion']);

    //Editar ticket de la base de datos
    Route::get('/tickets/{id_ticket}/editar', [ServicioController::class, 'edit']); 
    Route::get('/obtener-trabajadores', [EditarController::class, 'obtenerTrabajadoresPorSeccion']);
    Route::put('/tickets/{id_ticket}', [EditarController::class, 'editarTicket']);

    //Ver PDF y descargar PDF
    Route::get('/tickets/{id_ticket}/generar-pdf', [ServicioController::class, 'generarPdf']);
    Route::get('/tickets/{id_ticket}/ver-pdf', [ServicioController::class, 'verPdf']);


    Route::get('/acerca', function () {
        return view('acerca');
    });

    Route::post('/logout', [AuthWSDLController::class, 'destroy'])->name('logout');

});
