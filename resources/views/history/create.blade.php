@extends('layouts.app')

@section('title', 'WebCitaSys - Registrar Atención Médica')
@section('header_title', 'Registrar Atención')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ openPatientModal: false }">
    
    <!-- Navigation back link -->
    <div>
        @if($selectedPatient)
            <a href="{{ route('patients.show', $selectedPatient->id) }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Volver a la ficha de {{ $selectedPatient->full_name }}
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Volver al Panel Principal
            </a>
        @endif
    </div>

    <!-- Consultation Registry Card -->
    <div class="glass-card bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden relative">
        <!-- Top accent decoration -->
        <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3 mt-2">
            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">rate_review</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Nueva Consulta Clínica</h3>
                <p class="text-xs text-slate-400 font-semibold">Registro oficial de la atención en el historial médico</p>
            </div>
        </div>

        <form id="consultationForm" action="{{ route('history.store') }}" method="POST" novalidate 
              x-data="{ 
                  errors: { patient_id: '', symptoms: '', diagnosis: '' },
                  validateForm(e) {
                      let hasError = false;
                      this.errors = { patient_id: '', symptoms: '', diagnosis: '' };
                      
                      // Check patient_id
                      const patient = document.getElementById('patient_id');
                      if (patient && !patient.value) {
                          this.errors.patient_id = 'Debes seleccionar un paciente para atender.';
                          hasError = true;
                      }
                      
                      // Check symptoms
                      const symptoms = document.getElementById('symptoms');
                      if (!symptoms.value.trim()) {
                          this.errors.symptoms = 'El motivo o síntomas de la consulta son obligatorios.';
                          hasError = true;
                      }
                      
                      // Check diagnosis
                      const diagnosis = document.getElementById('diagnosis');
                      if (!diagnosis.value.trim()) {
                          this.errors.diagnosis = 'El diagnóstico clínico es obligatorio.';
                          hasError = true;
                      }
                      
                      if (hasError) {
                          e.preventDefault();
                          const firstErr = Object.keys(this.errors).find(k => this.errors[k]);
                          if (firstErr) {
                              const elem = document.getElementById(firstErr);
                              if (elem) {
                                  elem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                  elem.focus();
                              }
                          }
                      }
                  }
              }" 
              @submit="validateForm($event)"
              class="p-6 space-y-6 text-sm">
            @csrf

            <!-- Hidden appointment ID linking -->
            @if($selectedAppointment)
                <input type="hidden" name="appointment_id" value="{{ $selectedAppointment->id }}">
            @endif

            <!-- Section 1: Patient and Doctor Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                <!-- Patient Selector -->
                <div class="space-y-1">
                    @if($selectedPatient)
                        <label for="patient_id" class="block font-bold text-slate-700">Paciente *</label>
                        <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">
                        <div class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800 text-sm flex items-center justify-between">
                            <span>{{ $selectedPatient->full_name }} (Doc: {{ $selectedPatient->document_number }})</span>
                            <span class="text-xs bg-primary-fixed text-primary px-2 py-0.5 rounded-full">Ficha Activa</span>
                        </div>
                    @else
                        <div class="flex justify-between items-center mb-1">
                            <label for="patient_id" class="block font-bold text-slate-700">Paciente *</label>
                            <button type="button" @click="openPatientModal = true" class="text-xs font-bold text-primary hover:underline flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-[14px]">person_add</span>
                                + Nuevo Paciente
                            </button>
                        </div>
                        <select name="patient_id" id="patient_id" required 
                                class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">Selecciona un paciente para atender...</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->full_name }} (Cédula: {{ $patient->document_number }})</option>
                            @endforeach
                        </select>
                        <div class="min-h-[22px] mt-1">
                            <span x-show="errors.patient_id" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.patient_id" x-cloak></span>
                        </div>
                    @endif
                </div>

                <!-- Doctor Selector (Fixed to current doctor or dropdown) -->
                <div class="space-y-1">
                    <label for="doctor_id" class="block font-bold text-slate-700">Médico que Atiende *</label>
                    @if(Auth::user() && Auth::user()->doctor)
                        <input type="hidden" name="doctor_id" value="{{ Auth::user()->doctor->id }}">
                        <div class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800 text-sm">
                            {{ Auth::user()->name }} ({{ Auth::user()->doctor->specialty }})
                        </div>
                    @else
                        <select name="doctor_id" id="doctor_id" required 
                                class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">Selecciona médico...</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->full_name }} ({{ $doctor->specialty }})
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <!-- Section 2: Physiological Constants / Vitals -->
            <div class="space-y-3 pb-6 border-b border-slate-100">
                <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-primary text-lg">ecg</span>
                    Constantes Fisiológicas y Signos Vitales
                </h4>
                
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                    <!-- Weight -->
                    <div class="space-y-1">
                        <label for="weight" class="block text-xs font-semibold text-slate-500">Peso (kg)</label>
                        <input type="text" name="weight" id="weight" value="{{ old('weight') }}"
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-center text-sm" placeholder="Ej. 70">
                    </div>
                    <!-- Height -->
                    <div class="space-y-1">
                        <label for="height" class="block text-xs font-semibold text-slate-500">Estatura (cm)</label>
                        <input type="text" name="height" id="height" value="{{ old('height') }}"
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-center text-sm" placeholder="Ej. 175">
                    </div>
                    <!-- Temperature -->
                    <div class="space-y-1">
                        <label for="temperature" class="block text-xs font-semibold text-slate-500">Temperatura (°C)</label>
                        <input type="text" name="temperature" id="temperature" value="{{ old('temperature') }}"
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-center text-sm" placeholder="Ej. 36.5">
                    </div>
                    <!-- Blood Pressure -->
                    <div class="space-y-1">
                        <label for="blood_pressure" class="block text-xs font-semibold text-slate-500">Presión Art.</label>
                        <input type="text" name="blood_pressure" id="blood_pressure" value="{{ old('blood_pressure') }}"
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-center text-sm" placeholder="Ej. 120/80">
                    </div>
                    <!-- Heart Rate -->
                    <div class="space-y-1">
                        <label for="heart_rate" class="block text-xs font-semibold text-slate-500">Frec. Card. (lpm)</label>
                        <input type="text" name="heart_rate" id="heart_rate" value="{{ old('heart_rate') }}"
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-center text-sm" placeholder="Ej. 72">
                    </div>
                </div>
            </div>

            <!-- Section 3: Symptoms and diagnosis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                <!-- Symptoms -->
                <div class="space-y-1">
                    <label for="symptoms" class="block font-bold text-slate-700">Motivo / Síntomas *</label>
                    <textarea name="symptoms" id="symptoms" rows="4" required
                              class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm leading-relaxed" 
                              placeholder="Describe en detalle las razones de la consulta y síntomas manifestados por el paciente...">{{ old('symptoms') }}</textarea>
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.symptoms" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.symptoms" x-cloak></span>
                    </div>
                </div>
                
                <!-- Diagnosis -->
                <div class="space-y-1">
                    <label for="diagnosis" class="block font-bold text-slate-700">Diagnóstico Clínico *</label>
                    <textarea name="diagnosis" id="diagnosis" rows="4" required
                              class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm leading-relaxed" 
                              placeholder="Escribe el diagnóstico médico, conclusiones clínicas o códigos CIE-10 asociados...">{{ old('diagnosis') }}</textarea>
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.diagnosis" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.diagnosis" x-cloak></span>
                    </div>
                </div>
            </div>

            <!-- Section 4: Treatment & Prescription -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Treatment -->
                <div class="space-y-1">
                    <label for="treatment" class="block font-bold text-slate-700">Tratamiento / Recomendaciones</label>
                    <textarea name="treatment" id="treatment" rows="4" 
                              class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm leading-relaxed" 
                              placeholder="Ej. Realizar reposo por 3 días. Limpieza diaria de la herida con suero fisiológico. Dieta baja en sodio...">{{ old('treatment') }}</textarea>
                </div>

                <!-- Prescription / Medication Recipe -->
                <div class="space-y-1">
                    <label for="prescription" class="block font-bold text-slate-700">Receta Médica / Prescripción</label>
                    <textarea name="prescription" id="prescription" rows="4" 
                              class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm font-mono text-xs leading-relaxed" 
                              placeholder="1. Paracetamol 500mg - Tomar 1 tableta cada 8 horas por 3 días.&#10;2. Gasas estériles - Aplicar gasas protectoras..."></textarea>
                </div>
            </div>

            <!-- Buttons bar -->
            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" 
                        class="px-5 py-2.5 border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-xl transition-all shadow-md text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Guardar y Completar Atención
                </button>
            </div>

        </form>
    </div>

    <!-- Alpine Modal: Registrar Paciente Rápido -->
    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black/50 p-4" 
         x-show="openPatientModal" 
         x-transition
         x-cloak>
        <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100" @click.away="openPatientModal = false">
            <div class="bg-inverse-surface p-6 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-fixed">person_add</span>
                    Registrar Nuevo Paciente
                </h3>
                <button @click="openPatientModal = false" class="text-white hover:text-slate-300 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form action="{{ route('patients.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div class="space-y-1">
                        <label for="first_name" class="block text-xs font-bold text-slate-700">Nombre(s) *</label>
                        <input type="text" name="first_name" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Juan">
                    </div>
                    <!-- Last Name -->
                    <div class="space-y-1">
                        <label for="last_name" class="block text-xs font-bold text-slate-700">Apellido(s) *</label>
                        <input type="text" name="last_name" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Pérez">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Document Type -->
                    <div class="space-y-1">
                        <label for="document_type" class="block text-xs font-bold text-slate-700">Tipo Doc *</label>
                        <select name="document_type" required 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="TI">Tarjeta Identidad</option>
                            <option value="Pasaporte">Pasaporte</option>
                            <option value="RC">Registro Civil</option>
                        </select>
                    </div>
                    <!-- Document Number -->
                    <div class="space-y-1 col-span-2">
                        <label for="document_number" class="block text-xs font-bold text-slate-700">Nº de Documento *</label>
                        <input type="text" name="document_number" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="12345678">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div class="space-y-1">
                        <label for="phone" class="block text-xs font-bold text-slate-700">Celular / Teléfono</label>
                        <input type="text" name="phone" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="3112223344">
                    </div>
                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-xs font-bold text-slate-700">Correo Electrónico</label>
                        <input type="email" name="email" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="juan@correo.com">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Birth Date -->
                    <div class="space-y-1">
                        <label for="birth_date" class="block text-xs font-bold text-slate-700">Fecha Nac.</label>
                        <input type="date" name="birth_date" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                    </div>
                    <!-- Gender -->
                    <div class="space-y-1">
                        <label for="gender" class="block text-xs font-bold text-slate-700">Género</label>
                        <select name="gender" 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">Selecciona...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <!-- Blood Type -->
                    <div class="space-y-1">
                        <label for="blood_type" class="block text-xs font-bold text-slate-700">Rh / Sangre</label>
                        <select name="blood_type" 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">RH...</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-1">
                    <label for="address" class="block text-xs font-bold text-slate-700">Dirección</label>
                    <input type="text" name="address" 
                           class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Calle 100 #15-30, Bogotá">
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="openPatientModal = false" 
                            class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-bold transition-all text-sm">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 bg-primary hover:bg-primary-container text-white font-bold rounded-xl transition-all shadow-md text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">check</span>
                        Guardar Paciente
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
