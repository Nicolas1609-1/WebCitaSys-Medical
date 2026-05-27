@extends('layouts.app')

@section('title', 'WebCitaSys - Agenda de Citas')
@section('header_title', 'Agenda y Citas')

@section('content')
<div class="space-y-6" x-data="{ openPatientModal: false }">
    
    <!-- Top Filter/Date Bar -->
    <div class="glass-card bg-white rounded-xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <!-- Date Selector Filter -->
        <form action="{{ route('appointments.index') }}" method="GET" class="flex items-center gap-3">
            <label for="date" class="text-sm font-bold text-slate-700">Seleccionar Fecha:</label>
            <div class="flex items-center gap-2">
                <input type="date" name="date" id="date" value="{{ $selectedDate->toDateString() }}" 
                       class="px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-xl transition-all shadow-md">
                    Filtrar
                </button>
            </div>
        </form>

        <!-- Date Header Display -->
        <div class="text-right">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 justify-end">
                <span class="material-symbols-outlined text-primary">calendar_month</span>
                {{ $selectedDate->isoFormat('LL') }}
            </h3>
            <p class="text-xs text-slate-400 font-semibold">{{ $appointments->count() }} citas agendadas para este día</p>
        </div>
    </div>

    <!-- Main Grid split: Agendar Form (Left) vs Daily Agenda (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Panel: Agendar Cita Form (4 cols) - Solo recepcionistas y admins -->
        @can('appointments.create')
        <div class="col-span-12 lg:col-span-4 glass-card bg-white rounded-xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
            <!-- Top bar indicator -->
            <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
            
            <h3 class="text-base font-bold text-slate-800 pb-3 border-b border-slate-100 mb-4 flex items-center gap-2 mt-2">
                <span class="material-symbols-outlined text-primary">schedule_send</span>
                Agendar Nueva Cita
            </h3>
            
            <form action="{{ route('appointments.store') }}" method="POST" novalidate
                  x-data="{
                      errors: { patient_id: '', doctor_id: '', appointment_date: '', appointment_time: '', reason: '' },
                      validateForm(e) {
                          let hasError = false;
                          this.errors = { patient_id: '', doctor_id: '', appointment_date: '', appointment_time: '', reason: '' };
                          
                          if (!document.getElementById('patient_id').value) {
                              this.errors.patient_id = 'Debes seleccionar un paciente.';
                              hasError = true;
                          }
                          if (!document.getElementById('doctor_id').value) {
                              this.errors.doctor_id = 'Debes seleccionar un médico.';
                              hasError = true;
                          }
                          if (!document.getElementById('appointment_date').value) {
                              this.errors.appointment_date = 'Debes seleccionar una fecha.';
                              hasError = true;
                          }
                          if (!document.getElementById('appointment_time').value) {
                              this.errors.appointment_time = 'Debes seleccionar una hora.';
                              hasError = true;
                          }
                          if (!document.getElementById('reason').value.trim()) {
                              this.errors.reason = 'El motivo de consulta es obligatorio.';
                              hasError = true;
                          }
                          
                          if (hasError) {
                              e.preventDefault();
                          }
                      }
                  }"
                  @submit="validateForm($event)"
                  class="space-y-4 text-sm">
                @csrf
                
                <!-- Patient Selector -->
                <div class="space-y-1">
                    <div class="flex justify-between items-center mb-1">
                        <label for="patient_id" class="block font-semibold text-slate-700">Paciente *</label>
                        <button type="button" @click="openPatientModal = true" class="text-xs font-bold text-primary hover:underline flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-[14px]">person_add</span>
                            + Nuevo Paciente
                        </button>
                    </div>
                    <select name="patient_id" id="patient_id" required 
                            class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                        <option value="">Selecciona un paciente...</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->full_name }} (Doc: {{ $patient->document_number }})</option>
                        @endforeach
                    </select>
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.patient_id" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.patient_id" x-cloak></span>
                        @error('patient_id')
                            <span class="text-xs text-red-600 font-semibold block leading-tight">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <!-- Doctor Selector -->
                <div class="space-y-1">
                    <label for="doctor_id" class="block font-semibold text-slate-700">Médico Tratante *</label>
                    <select name="doctor_id" id="doctor_id" required 
                            class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                        <option value="">Selecciona un médico...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->full_name }} - ({{ $doctor->specialty }})</option>
                        @endforeach
                    </select>
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.doctor_id" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.doctor_id" x-cloak></span>
                        @error('doctor_id')
                            <span class="text-xs text-red-600 font-semibold block leading-tight">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Date Selector -->
                    <div class="space-y-1">
                        <label for="appointment_date" class="block font-semibold text-slate-700">Fecha Cita *</label>
                        <input type="date" name="appointment_date" id="appointment_date" required value="{{ $selectedDate->toDateString() }}"
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                        <div class="min-h-[22px] mt-1">
                            <span x-show="errors.appointment_date" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.appointment_date" x-cloak></span>
                            @error('appointment_date')
                                <span class="text-xs text-red-600 font-semibold block leading-tight">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Time Selector -->
                    <div class="space-y-1">
                        <label for="appointment_time" class="block font-semibold text-slate-700">Hora Cita *</label>
                        <select name="appointment_time" id="appointment_time" required 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">Hora...</option>
                            <option value="08:00">08:00 AM</option>
                            <option value="08:30">08:30 AM</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="09:30">09:30 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="10:30">10:30 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="11:30">11:30 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="13:30">01:30 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="14:30">02:30 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="15:30">03:30 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="16:30">04:30 PM</option>
                        </select>
                        <div class="min-h-[22px] mt-1">
                            <span x-show="errors.appointment_time" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.appointment_time" x-cloak></span>
                            @error('appointment_time')
                                <span class="text-xs text-red-600 font-semibold block leading-tight">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Reason for Appointment -->
                <div class="space-y-1">
                    <label for="reason" class="block font-semibold text-slate-700">Motivo de Consulta *</label>
                    <input type="text" name="reason" id="reason" required 
                           class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" 
                           placeholder="Ej. Chequeo general de hipertensión">
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.reason" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.reason" x-cloak></span>
                        @error('reason')
                            <span class="text-xs text-red-600 font-semibold block leading-tight">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Doctor Notes -->
                <div class="space-y-1">
                    <label for="notes" class="block font-semibold text-slate-700">Notas Adicionales (Opcional)</label>
                    <textarea name="notes" id="notes" rows="2" 
                              class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" 
                              placeholder="Ej. El paciente debe traer exámenes de sangre..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">edit_calendar</span>
                    Agendar Cita Médica
                </button>
            </form>
        </div>
        @endcan
        
        <!-- Right Panel: Daily Appointments Agenda (8 cols, 12 si no hay form) -->
        <div class="col-span-12 {{ Auth::user()->hasPermission('appointments.create') ? 'lg:col-span-8' : 'lg:col-span-12' }} glass-card bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 pb-3 border-b border-slate-100 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">view_agenda</span>
                Cronograma del Día Seleccionado
            </h3>

            <div class="space-y-4">
                @forelse($appointments as $appt)
                    <div class="p-5 bg-slate-50 rounded-xl border border-slate-200/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-sm transition-all duration-200">
                        <div class="flex items-start gap-4">
                            <!-- Initials Avatar -->
                            <div class="w-12 h-12 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold text-lg border border-primary/10 mt-1">
                                {{ strtoupper(substr($appt->patient->first_name, 0, 1) . substr($appt->patient->last_name, 0, 1)) }}
                            </div>
                            
                            <div>
                                <h4 class="font-bold text-base text-slate-800">
                                    <a href="{{ route('patients.show', $appt->patient_id) }}" class="hover:text-primary transition-colors">{{ $appt->patient->full_name }}</a>
                                </h4>
                                <p class="text-xs text-slate-500 font-semibold">Cédula: {{ $appt->patient->document_number }}</p>
                                <p class="text-sm text-slate-600 mt-1"><span class="font-bold text-slate-700">Motivo:</span> {{ $appt->reason }}</p>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs text-slate-400">clinical_notes</span>
                                    Atendido por: <span class="font-bold text-slate-700">{{ $appt->doctor->full_name }} ({{ $appt->doctor->specialty }})</span>
                                </p>
                            </div>
                        </div>

                        <!-- Date and Status Changers -->
                        <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-3 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-200/40">
                            <!-- Time display -->
                            <div class="text-right">
                                <p class="font-bold text-lg text-slate-800 flex items-center gap-1 justify-end">
                                    <span class="material-symbols-outlined text-slate-400 text-sm">schedule</span>
                                    {{ $appt->appointment_date->format('H:i') }}
                                </p>
                            </div>

                            <!-- State status and actions -->
                            <div class="flex items-center gap-2">
                                @if($appt->status == 'Confirmada')
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">Confirmada</span>
                                @elseif($appt->status == 'Pendiente')
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">Pendiente</span>
                                @elseif($appt->status == 'Completada')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold border border-blue-200">Completada</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold border border-rose-200">Cancelada</span>
                                @endif
                                
                                <!-- Status changers triggers -->
                                @if($appt->status != 'Completada' && $appt->status != 'Cancelada')
                                    <div class="flex gap-1" x-data="{ openMenu: false }">
                                        <!-- Botón de atención (Completar cita con registro) -->
                                        <a href="{{ route('history.create', ['appointment_id' => $appt->id]) }}" 
                                           class="px-2 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-container transition-all flex items-center gap-1" 
                                           title="Registrar Atención">
                                            <span class="material-symbols-outlined text-sm">rate_review</span>
                                            Atender
                                        </a>

                                        <!-- Menú desplegable de cambio de estado rápido -->
                                        <div class="relative">
                                            <button @click="openMenu = !openMenu" class="p-1.5 border border-slate-200 bg-white hover:bg-slate-50 rounded-lg flex items-center justify-center">
                                                <span class="material-symbols-outlined text-sm text-slate-500">settings</span>
                                            </button>
                                            
                                            <!-- Dropdown content -->
                                            <div class="absolute right-0 mt-1 w-36 bg-white border border-slate-100 rounded-xl shadow-xl z-20 p-1" 
                                                 x-show="openMenu" 
                                                 @click.away="openMenu = false" 
                                                 x-cloak>
                                                
                                                @if($appt->status == 'Pendiente')
                                                    <!-- Confirmar -->
                                                    <form action="{{ route('appointments.updateStatus', $appt->id) }}" method="POST" class="w-full">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Confirmada">
                                                        <button type="submit" class="w-full text-left px-3 py-1.5 text-xs font-bold hover:bg-slate-50 text-emerald-600 rounded-lg flex items-center gap-1.5">
                                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                                            Confirmar
                                                        </button>
                                                    </form>
                                                @endif

                                                @can('appointments.cancel')
                                                <!-- Cancelar -->
                                                <form action="{{ route('appointments.updateStatus', $appt->id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Cancelada">
                                                    <button type="submit" class="w-full text-left px-3 py-1.5 text-xs font-bold hover:bg-slate-50 text-rose-600 rounded-lg flex items-center gap-1.5">
                                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                                        Cancelar
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-slate-400 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">hotel_class</span>
                        <p class="text-sm font-semibold">No se registran citas agendadas para esta fecha.</p>
                        <p class="text-xs text-slate-400 mt-1">Usa el formulario de la izquierda para programar una.</p>
                    </div>
                @endforelse
            </div>
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
