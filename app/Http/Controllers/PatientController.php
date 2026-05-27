<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();

        $patients = Patient::query()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('document_number', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->with(['nextAppointment' => function ($q) use ($user) {
                if ($user->isDoctor() && $user->doctor) {
                    $q->where('doctor_id', $user->doctor->id);
                }
            }])
            ->orderBy('last_name', 'asc')
            ->paginate(10);

        return view('patients.index', compact('patients', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:10',
            'document_number' => 'required|string|max:50|unique:patients',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
        ]);

        $patient = Patient::create($validated);

        $this->auditService->logCreated('patients', $patient, "Paciente {$patient->full_name} registrado por " . Auth::user()->name);

        return redirect()->back()->with('success', 'Paciente registrado exitosamente.');
    }

    public function show($id)
    {
        $patient = Patient::with(['clinicalRecords.doctor', 'appointments.doctor'])
                          ->findOrFail($id);

        return view('patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:10',
            'document_number' => 'required|string|max:50|unique:patients,document_number,' . $id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
        ]);

        $oldData = $patient->toArray();
        $patient->update($validated);

        $this->auditService->logUpdated('patients', $patient, $oldData, "Paciente {$patient->full_name} actualizado por " . Auth::user()->name);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Paciente actualizado exitosamente.');
    }
}
