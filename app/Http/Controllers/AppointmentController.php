<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request)
    {
        $dateStr = $request->input('date', Carbon::today()->toDateString());
        $selectedDate = Carbon::parse($dateStr);

        $query = Appointment::whereDate('appointment_date', $selectedDate)
            ->with(['patient', 'doctor']);

        if (Auth::user()->isDoctor() && Auth::user()->doctor) {
            $query->where('doctor_id', Auth::user()->doctor->id);
        }

        $appointments = $query->orderBy('appointment_date', 'asc')->get();
        $patients = Patient::orderBy('last_name', 'asc')->get();
        $doctors = Doctor::orderBy('last_name', 'asc')->get();

        return view('appointments.index', compact('appointments', 'selectedDate', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Validar duplicados: mismo paciente, mismo médico, misma fecha y hora
        $dateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        $existingAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $dateTime)
            ->whereIn('status', ['Pendiente', 'Confirmada'])
            ->first();

        if ($existingAppointment) {
            return redirect()->back()->withErrors([
                'appointment_time' => 'El paciente ya tiene una cita agendada con este médico en esta fecha y hora.',
            ])->withInput();
        }

        // Validar conflicto de horario del médico
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $dateTime)
            ->whereIn('status', ['Pendiente', 'Confirmada'])
            ->first();

        if ($doctorConflict) {
            return redirect()->back()->withErrors([
                'appointment_time' => 'El médico ya tiene una cita agendada en este horario.',
            ])->withInput();
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $dateTime,
            'reason' => $request->reason,
            'status' => 'Pendiente',
            'notes' => $request->notes,
        ]);

        $this->auditService->logCreated('appointments', $appointment, "Cita agendada para {$appointment->patient?->full_name} con {$appointment->doctor?->full_name}");

        return redirect()->back()->with('success', 'Cita agendada correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pendiente,Confirmada,Completada,Cancelada',
        ]);

        $appointment = Appointment::with('patient', 'doctor')->findOrFail($id);

        $oldStatus = $appointment->status;
        $appointment->update(['status' => $request->status]);

        $this->auditService->log(
            'updated',
            'appointments',
            "Cita de {$appointment->patient?->full_name} cambió de {$oldStatus} a {$request->status}",
            ['status' => $oldStatus],
            ['status' => $request->status]
        );

        return redirect()->back()->with('success', 'Estado de la cita actualizado.');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (in_array($appointment->status, ['Completada', 'Cancelada'])) {
            return back()->withErrors(['error' => 'No se puede cancelar una cita que ya está completada o cancelada.']);
        }

        $appointment->update(['status' => 'Cancelada']);

        $this->auditService->logUpdated('appointments', $appointment, ['status' => $appointment->status], "Cita cancelada por " . Auth::user()->name);

        return redirect()->back()->with('success', 'Cita cancelada exitosamente.');
    }
}
