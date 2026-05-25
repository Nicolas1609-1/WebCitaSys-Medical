<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicalHistoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Patient\AuthController as PatientAuthController;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicalRecord;
use App\Models\Doctor;
use App\Models\AuditLog;

// ==================== RUTAS PÚBLICAS ====================

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Autenticación de Personal (Doctores/Staff)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Autenticación de Pacientes
Route::prefix('paciente')->name('patient.')->middleware('guest')->group(function () {
    Route::get('/login', [PatientAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PatientAuthController::class, 'login']);
    Route::get('/register', [PatientAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [PatientAuthController::class, 'register']);
});

// ==================== RUTAS PROTEGIDAS (STAFF + PACIENTES) ====================

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (redirige según rol)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== MÓDULO PACIENTES ====================
    Route::middleware('permission:patients.view')->group(function () {
        Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
    });

    Route::middleware('permission:patients.create')->group(function () {
        Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    });

    Route::middleware('permission:patients.edit')->group(function () {
        Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    });

    // ==================== MÓDULO CITAS ====================
    Route::middleware('permission:appointments.view|appointments.view_assigned|appointments.view_own')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    });

    Route::middleware('permission:appointments.create')->group(function () {
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    });

    Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])
        ->middleware('permission:appointments.update_status')
        ->name('appointments.updateStatus');

    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])
        ->middleware('permission:appointments.cancel')
        ->name('appointments.cancel');

    // ==================== HISTORIAL CLÍNICO ====================
    Route::middleware('permission:clinical_records.create')->group(function () {
        Route::get('/history/create', [ClinicalHistoryController::class, 'create'])->name('history.create');
        Route::post('/history', [ClinicalHistoryController::class, 'store'])->name('history.store');
    });

    // ==================== REPORTES ====================
    Route::middleware('permission:reports.view_financial|reports.view_statistics|reports.view_personal')->group(function () {
        Route::get('/reports', function () {
            $totalPatients = Patient::count();
            $totalAppointments = Appointment::count();
            $completedAppointments = Appointment::where('status', 'Completada')->count();
            $canceledAppointments = Appointment::where('status', 'Cancelada')->count();

            $statusCounts = [
                'Confirmada' => Appointment::where('status', 'Confirmada')->count(),
                'Pendiente' => Appointment::where('status', 'Pendiente')->count(),
                'Completada' => $completedAppointments,
                'Cancelada' => $canceledAppointments,
            ];

            $specialtyCounts = [
                'Cardiología' => ClinicalRecord::whereHas('doctor', fn($q) => $q->where('specialty', 'Cardiología'))->count(),
                'Medicina General' => ClinicalRecord::whereHas('doctor', fn($q) => $q->where('specialty', 'Medicina General'))->count(),
                'Pediatría' => ClinicalRecord::whereHas('doctor', fn($q) => $q->where('specialty', 'Pediatría'))->count(),
            ];

            $monthlyRevenue = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthlyRevenue[date('F', mktime(0, 0, 0, $i, 1))] = Appointment::whereMonth('appointment_date', $i)
                    ->whereYear('appointment_date', now()->year)
                    ->where('status', 'Completada')
                    ->count();
            }

            return view('reports.index', compact('totalPatients', 'totalAppointments', 'statusCounts', 'specialtyCounts', 'monthlyRevenue'));
        })->name('reports.index');
    });

    // ==================== ADMINISTRACIÓN DE USUARIOS (Solo Admin) ====================
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Horarios
        Route::get('/schedules', function () {
            $doctors = Doctor::with('schedules')->orderBy('last_name')->get();
            return view('admin.schedules.index', compact('doctors'));
        })->name('schedules.index');

        // Dashboard de sistema
        Route::get('/system', function () {
            $logs = AuditLog::with('user')->latest()->take(50)->get();
            return view('admin.system.index', compact('logs'));
        })->name('system.index');
    });

    // ==================== NOTIFICACIONES ====================
    Route::post('/notificaciones/leer-todas', function () {
        \App\Models\Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    })->name('notifications.read-all');

    // ==================== CONSULTAS DE PACIENTE (Auto-servicio) ====================
    Route::middleware('role:patient')->group(function () {
        Route::get('/mis-citas', function () {
            $user = Auth::user();
            $patient = $user->patient;
            $appointments = Appointment::where('patient_id', $patient?->id)
                ->with('doctor')
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
            $doctors = Doctor::orderBy('last_name')->get();
            return view('patient.appointments.index', compact('appointments', 'doctors'));
        })->name('patient.appointments');

        Route::post('/mis-citas/agendar', function (Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date|after:now',
                'reason' => 'required|string|max:500',
            ]);

            $patient = Auth::user()->patient;

            if (!$patient) {
                return back()->withErrors(['error' => 'Perfil de paciente no encontrado.']);
            }

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $validated['doctor_id'],
                'appointment_date' => $validated['appointment_date'],
                'reason' => $validated['reason'],
                'status' => 'Pendiente',
            ]);

            return redirect()->route('patient.appointments')
                ->with('success', 'Cita agendada exitosamente. Espera la confirmación.');
        })->name('patient.appointments.store');

        Route::get('/mi-historial', function () {
            $user = Auth::user();
            $patient = $user->patient;
            $records = ClinicalRecord::where('patient_id', $patient?->id)
                ->with('doctor')
                ->latest()
                ->paginate(10);
            return view('patient.history.index', compact('records'));
        })->name('patient.history');
    });
});
