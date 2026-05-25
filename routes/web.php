<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicalHistoryController;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicalRecord;

// Redirección inicial
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// Rutas de Autenticación (Públicas)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Recuperación de Contraseña
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Rutas Protegidas por Autenticación
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Panel Principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Pacientes
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');

    // CRUD Citas / Agenda
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    // Historial Clínico / Registrar Atención
    Route::get('/history/create', [ClinicalHistoryController::class, 'create'])->name('history.create');
    Route::post('/history', [ClinicalHistoryController::class, 'store'])->name('history.store');

    // Módulo de Reportes (Calculado en la misma ruta)
    Route::get('/reports', function () {
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('status', 'Completada')->count();
        $canceledAppointments = Appointment::where('status', 'Cancelada')->count();

        // Citas agrupadas por estado para gráficos
        $statusCounts = [
            'Confirmada' => Appointment::where('status', 'Confirmada')->count(),
            'Pendiente' => Appointment::where('status', 'Pendiente')->count(),
            'Completada' => $completedAppointments,
            'Cancelada' => $canceledAppointments
        ];

        // Especialidades con más atenciones
        $specialtyCounts = [
            'Cardiología' => ClinicalRecord::whereHas('doctor', function($q){ $q->where('specialty', 'Cardiología'); })->count(),
            'Medicina General' => ClinicalRecord::whereHas('doctor', function($q){ $q->where('specialty', 'Medicina General'); })->count(),
            'Pediatría' => ClinicalRecord::whereHas('doctor', function($q){ $q->where('specialty', 'Pediatría'); })->count(),
        ];

        return view('reports.index', compact('totalPatients', 'totalAppointments', 'statusCounts', 'specialtyCounts'));
    })->name('reports.index');
});


// Mi comentario de prueba
