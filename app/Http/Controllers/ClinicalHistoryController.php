<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClinicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClinicalHistoryController extends Controller
{
    public function create(Request $request)
    {
        $patientId = $request->input('patient_id');
        $appointmentId = $request->input('appointment_id');

        $selectedPatient = null;
        $selectedAppointment = null;

        if ($appointmentId) {
            $selectedAppointment = Appointment::with('patient', 'doctor')->findOrFail($appointmentId);
            $selectedPatient = $selectedAppointment->patient;
        } elseif ($patientId) {
            $selectedPatient = Patient::findOrFail($patientId);
        }

        // Si no hay médico logueado, tomamos el primer médico para el formulario
        $doctors = Doctor::orderBy('last_name', 'asc')->get();
        $patients = Patient::orderBy('last_name', 'asc')->get();

        return view('history.create', compact('selectedPatient', 'selectedAppointment', 'doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
            'temperature' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        // Registrar la atención médica
        $record = ClinicalRecord::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_id' => $request->appointment_id,
            'record_date' => Carbon::now(),
            'weight' => $request->weight,
            'height' => $request->height,
            'temperature' => $request->temperature,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
        ]);

        // Si esta atención está vinculada a una cita, marcarla como completada
        if ($request->appointment_id) {
            $appointment = Appointment::find($request->appointment_id);
            if ($appointment) {
                $appointment->update(['status' => 'Completada']);
            }
        }

        return redirect()->route('patients.show', $request->patient_id)
                         ->with('success', 'Atención registrada y guardada en el Historial Clínico.');
    }
}
