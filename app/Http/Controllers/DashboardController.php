<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicalRecord;
use App\Models\Doctor;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->role) {
            return redirect()->route('login')->withErrors(['access' => 'No tienes un rol asignado.']);
        }

        return match ($user->role->slug) {
            'admin' => $this->adminDashboard(),
            'doctor' => $this->doctorDashboard(),
            'receptionist' => $this->receptionistDashboard(),
            'financial' => $this->financialDashboard(),
            'support' => $this->supportDashboard(),
            'patient' => $this->patientDashboard(),
            default => $this->defaultDashboard(),
        };
    }

    private function adminDashboard()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $activeUsers = User::whereNotNull('role_id')->count();
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', $today)->count();

        $monthlyAppointments = Appointment::whereBetween('appointment_date', [$startOfMonth, Carbon::now()])->count();
        $monthlyCompleted = Appointment::where('status', 'Completada')
            ->whereBetween('appointment_date', [$startOfMonth, Carbon::now()])->count();

        $statusDistribution = [
            'Pendiente' => Appointment::where('status', 'Pendiente')->count(),
            'Confirmada' => Appointment::where('status', 'Confirmada')->count(),
            'Completada' => Appointment::where('status', 'Completada')->count(),
            'Cancelada' => Appointment::where('status', 'Cancelada')->count(),
        ];

        $recentUsers = User::with('role')->latest()->take(5)->get();

        return view('dashboards.admin', compact(
            'totalPatients', 'totalAppointments', 'activeUsers', 'todayAppointmentsCount',
            'monthlyAppointments', 'monthlyCompleted', 'statusDistribution', 'recentUsers'
        ));
    }

    private function doctorDashboard()
    {
        $today = Carbon::today();
        $now = Carbon::now();
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return redirect()->route('login')->withErrors(['access' => 'Perfil de médico no encontrado.']);
        }

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $today)
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $nextAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['Pendiente', 'Confirmada'])
            ->whereDate('appointment_date', '>=', $today)
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->take(10)
            ->get();

        $completedAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'Completada')
            ->whereDate('appointment_date', $today)
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        $recentRecords = ClinicalRecord::where('doctor_id', $doctor->id)
            ->with('patient')
            ->latest()
            ->take(5)
            ->get();

        $recentPatients = Patient::whereHas('appointments', function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            })
            ->orWhereHas('clinicalRecords', function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            })
            ->latest()
            ->take(5)
            ->get();

        $todayCount = $todayAppointments->count();
        $pendingCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'Pendiente')->count();
        $upcomingCount = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['Pendiente', 'Confirmada'])
            ->whereBetween('appointment_date', [$today, $now->copy()->addDays(7)])
            ->count();
        $monthlyCount = ClinicalRecord::where('doctor_id', $doctor->id)
            ->whereMonth('record_date', Carbon::now()->month)->count();
        $completedTodayCount = $completedAppointments->count();

        return view('dashboards.doctor', compact(
            'todayAppointments', 'nextAppointments', 'completedAppointments',
            'recentRecords', 'recentPatients',
            'todayCount', 'pendingCount', 'upcomingCount', 'monthlyCount',
            'completedTodayCount', 'doctor'
        ));
    }

    private function receptionistDashboard()
    {
        $today = Carbon::today();

        $todayAppointments = Appointment::whereDate('appointment_date', $today)
            ->with('patient', 'doctor')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $pendingAppointments = Appointment::where('status', 'Pendiente')
            ->whereDate('appointment_date', '>=', $today)
            ->with('patient', 'doctor')
            ->orderBy('appointment_date', 'asc')
            ->take(10)
            ->get();

        $recentPatients = Patient::latest()->take(5)->get();

        $todayAppointmentsCount = $todayAppointments->count();
        $pendingCount = Appointment::where('status', 'Pendiente')->count();
        $totalPatients = Patient::count();

        return view('dashboards.receptionist', compact(
            'todayAppointments', 'pendingAppointments', 'recentPatients',
            'todayAppointmentsCount', 'pendingCount', 'totalPatients'
        ));
    }

    private function financialDashboard()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        $monthlyAppointments = Appointment::whereBetween('appointment_date', [$startOfMonth, $today])->count();
        $completedThisMonth = Appointment::where('status', 'Completada')
            ->whereBetween('appointment_date', [$startOfMonth, $today])->count();
        $totalCompleted = Appointment::where('status', 'Completada')->count();
        $canceledCount = Appointment::where('status', 'Cancelada')->count();

        $monthlyStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyStats[date('F', mktime(0, 0, 0, $i, 1))] = Appointment::whereMonth('appointment_date', $i)
                ->whereYear('appointment_date', $today->year)
                ->count();
        }

        $statusCounts = [
            'Completada' => $totalCompleted,
            'Cancelada' => $canceledCount,
            'Pendiente' => Appointment::where('status', 'Pendiente')->count(),
            'Confirmada' => Appointment::where('status', 'Confirmada')->count(),
        ];

        $specialtyStats = Doctor::withCount(['appointments' => function ($q) {
                $q->where('status', 'Completada');
            }])
            ->get()
            ->map(fn($d) => ['specialty' => $d->specialty, 'count' => $d->appointments_count])
            ->groupBy('specialty')
            ->map(fn($group) => $group->sum('count'));

        return view('dashboards.financial', compact(
            'monthlyAppointments', 'completedThisMonth', 'totalCompleted',
            'canceledCount', 'monthlyStats', 'statusCounts', 'specialtyStats'
        ));
    }

    private function supportDashboard()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        $recentLogs = AuditLog::with('user')
            ->latest()
            ->take(20)
            ->get();

        $logCountToday = AuditLog::whereDate('created_at', $today)->count();
        $logCountMonth = AuditLog::whereMonth('created_at', Carbon::now()->month)->count();
        $activeUsers = User::whereNotNull('role_id')->count();
        $totalUsers = User::count();

        $actionsDistribution = AuditLog::selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'action');

        $moduleDistribution = AuditLog::selectRaw('module, COUNT(*) as count')
            ->groupBy('module')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'module');

        return view('dashboards.support', compact(
            'recentLogs', 'logCountToday', 'logCountMonth',
            'activeUsers', 'totalUsers', 'actionsDistribution', 'moduleDistribution'
        ));
    }

    private function patientDashboard()
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('login')->withErrors(['access' => 'Perfil de paciente no encontrado.']);
        }

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['Pendiente', 'Confirmada'])
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->with('doctor')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['Completada', 'Cancelada'])
            ->with('doctor')
            ->latest('appointment_date')
            ->take(5)
            ->get();

        $medicalRecords = ClinicalRecord::where('patient_id', $patient->id)
            ->with('doctor')
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = \App\Models\Notification::where('user_id', $user->id)
            ->unread()
            ->latest()
            ->take(10)
            ->get();

        return view('dashboards.patient', compact(
            'upcomingAppointments', 'pastAppointments',
            'medicalRecords', 'unreadNotifications', 'patient'
        ));
    }

    private function defaultDashboard()
    {
        return redirect()->route('login')->withErrors(['access' => 'Rol no reconocido.']);
    }
}
