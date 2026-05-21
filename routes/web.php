<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrearController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EditarController;
use App\Http\Controllers\AuthWSDLController;
use App\Http\Middleware\VerificarSesionUAM;
use App\Livewire\TicketSearch;
use App\Livewire\TicketSearchUser;
use App\Livewire\TicketSearchSecc;

// ==========================================
// Ruta Pública (No requiere sesión)
// ==========================================
Route::get('/', [AuthWSDLController::class, 'mostrarFormulario'])->name('login'); 
Route::post('/', [AuthWSDLController::class, 'procesarLogin'])->name('login.uam');

// ==========================================
// Rutas Protegidas (Requieren sesión y sin caché)
// ==========================================
Route::middleware([VerificarSesionUAM::class, 'prevent-back'])->group(function () {

    // ------------------------------------------
    // RUTAS GLOBALES (Todos los usuarios autenticados)
    // ------------------------------------------
    Route::get('/mis-tickets', TicketSearchUser::class)->name('tickets.usuario');
    Route::get('/show', function() { return view('show'); });
    Route::get('/tickets/index', [ConsultaController::class, 'mostrarFormulario'])->name('consultar.form');
    Route::post('/tickets/buscar', [ConsultaController::class, 'buscarTicket'])->name('consultar.buscar'); // Corregido URI
    
    // Ver y descargar PDF (Se asume que el controlador valida que el ticket sea del usuario)
    Route::get('/tickets/{id_ticket}/generar-pdf', [ServicioController::class, 'generarPdf']);
    Route::get('/tickets/{id_ticket}/ver-pdf', [ServicioController::class, 'verPdf']);

    Route::get('/acerca', function () { return view('acerca'); });
    Route::post('/logout', [AuthWSDLController::class, 'destroy'])->name('logout');

    // ------------------------------------------
    // LEVANTAR TICKETS (Todos los roles permitidos)
    // ------------------------------------------
    Route::middleware(['role:usuario,admin,coordinador,seccion'])->group(function () {
        Route::get('/tickets/create', [CrearController::class, 'create'])->name('tickets.create');
        Route::get('/buscar-usuario/{num_economico}', [CrearController::class, 'buscarPorNomina']);
        Route::post('/guardar-datos-personales', [CrearController::class, 'storeDatosPersonales']);
        Route::post('/tickets', [CrearController::class, 'crear'])->name('tickets.store');
        Route::get('/api/departamentos', [CrearController::class, 'getDepartamentos']);
        Route::get('/api/areas', [CrearController::class, 'getAreas']);
    });

    // ------------------------------------------
    // STAFF (Solo personal de atención: Admin, Coord, Secc)
    // ------------------------------------------
    Route::middleware(['role:admin,coordinador,seccion'])->group(function () {
        Route::get('/tickets/{id_ticket}/editar', [ServicioController::class, 'edit']); 
        Route::put('/tickets/{id_ticket}', [EditarController::class, 'editarTicket']);
        Route::get('/obtener-trabajadores', [EditarController::class, 'obtenerTrabajadoresPorSeccion']);
    });

    // ------------------------------------------
    // ADMINISTRADOR
    // ------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', TicketSearch::class); 
        Route::get('/tickets/all', function() { return view('tickets.all'); }); // Protegida por si acaso
    });

    // ------------------------------------------
    // COORDINADORES (y Admin)
    // ------------------------------------------
    Route::middleware(['role:coordinador,admin'])->group(function () {
        Route::get('/coords/{id}', [ServicioController::class, 'ticketsPorCoordinacion']);
    });

    // ------------------------------------------
    // SECCIONES (y Admin)
    // ------------------------------------------
    Route::middleware(['role:seccion,admin'])->group(function () {
        Route::get('/seccs/{id}', [ServicioController::class, 'ticketsPorSeccion']);
    });

});