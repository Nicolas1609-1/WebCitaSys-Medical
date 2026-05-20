<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patients = Patient::query()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('document_number', 'like', "%{$search}%");
            })
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

        Patient::create($validated);

        return redirect()->back()->with('success', 'Paciente registrado exitosamente.');
    }

    public function show($id)
    {
        $patient = Patient::with(['clinicalRecords.doctor', 'appointments.doctor'])
                          ->findOrFail($id);

        return view('patients.show', compact('patient'));
    }
}
