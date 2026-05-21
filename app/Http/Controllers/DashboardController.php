<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicalRecord;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Estadísticas para los KPI
        $totalPatients = Patient::count();
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', $today)->count();
        $pendingAppointmentsCount = Appointment::where('status', 'Pendiente')->count();
        $monthlyAttentionsCount = ClinicalRecord::whereMonth('record_date', Carbon::now()->month)
                                                ->whereYear('record_date', Carbon::now()->year)
                                                ->count();

        // Citas de hoy completadas
        $todayCompletedCount = Appointment::whereDate('appointment_date', $today)
                                           ->where('status', 'Completada')
                                           ->count();

        // 2. Listado de Citas de Hoy
        $todayAppointments = Appointment::whereDate('appointment_date', $today)
                                        ->with('patient', 'doctor')
                                        ->orderBy('appointment_date', 'asc')
                                        ->get();

        // 3. Pacientes Recientes
        $recentPatients = Patient::orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();

        return view('dashboard', compact(
            'totalPatients',
            'todayAppointmentsCount',
            'pendingAppointmentsCount',
            'monthlyAttentionsCount',
            'todayCompletedCount',
            'todayAppointments',
            'recentPatients'
        ));
    }
}
