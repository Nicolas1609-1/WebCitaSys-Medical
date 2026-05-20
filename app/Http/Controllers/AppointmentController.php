<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $dateStr = $request->input('date', Carbon::today()->toDateString());
        $selectedDate = Carbon::parse($dateStr);

        // Cargar citas para el día seleccionado
        $appointments = Appointment::whereDate('appointment_date', $selectedDate)
            ->with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Para el selector del formulario de agendamiento
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

        // Combinar fecha y hora
        $dateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $dateTime,
            'reason' => $request->reason,
            'status' => 'Pendiente', // por defecto
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Cita agendada correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pendiente,Confirmada,Completada,Cancelada',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Estado de la cita actualizado.');
    }
}
