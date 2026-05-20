@extends('layouts.app')

@section('title', 'WebCitaSys - Panel Principal')
@section('header_title', 'Panel Principal')

@section('content')
<!-- KPI Grid -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- KPI 1: Pacientes -->
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-primary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Pacientes Registrados</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $totalPatients }}</h3>
                <p class="text-secondary text-xs flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-xs">trending_up</span>
                    Activos en el sistema
                </p>
            </div>
            <div class="p-3 bg-primary-fixed rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
        </div>
    </div>
    
    <!-- KPI 2: Citas Hoy -->
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-secondary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas Agendadas Hoy</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $todayAppointmentsCount }}</h3>
                <p class="text-slate-500 text-xs mt-2">{{ $todayCompletedCount }} completadas hoy</p>
            </div>
            <div class="p-3 bg-secondary-fixed rounded-xl text-secondary">
                <span class="material-symbols-outlined text-2xl">calendar_today</span>
            </div>
        </div>
    </div>
    
    <!-- KPI 3: Pendientes -->
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-error bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas Pendientes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $pendingAppointmentsCount }}</h3>
                <p class="text-error text-xs mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">pending_actions</span>
                    Requieren confirmación
                </p>
            </div>
            <div class="p-3 bg-error-container rounded-xl text-error">
                <span class="material-symbols-outlined text-2xl">history_toggle_off</span>
            </div>
        </div>
    </div>
    
    <!-- KPI 4: Atenciones Mes -->
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-surface-tint bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Atenciones del Mes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $monthlyAttentionsCount }}</h3>
                <p class="text-secondary text-xs flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-xs">check_circle</span>
                    Consultas completadas
                </p>
            </div>
            <div class="p-3 bg-surface-container-highest rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">show_chart</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Dashboard Layout -->
<div class="bento-grid" x-data="{ openPatientModal: false }">
    <!-- Left Column: Citas de Hoy (Bento Big) -->
    <div class="col-span-12 lg:col-span-8 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">event_note</span>
                    Citas programadas para Hoy
                </h4>
                <a class="text-primary font-bold text-sm flex items-center gap-1 hover:underline" href="{{ route('appointments.index') }}">
                    Ver agenda completa
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($todayAppointments as $appointment)
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <!-- Initials Avatar -->
                            <div class="w-12 h-12 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold text-lg border border-primary/10">
                                {{ strtoupper(substr($appointment->patient->first_name, 0, 1) . substr($appointment->patient->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-base text-slate-800 hover:text-primary transition-colors">
                                    <a href="{{ route('patients.show', $appointment->patient_id) }}">{{ $appointment->patient->full_name }}</a>
                                </p>
                                <p class="text-sm text-slate-500">
                                    {{ $appointment->doctor->full_name }} - <span class="text-xs font-semibold px-2 py-0.5 bg-slate-100 rounded-full">{{ $appointment->doctor->specialty }}</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 justify-between sm:justify-end">
                            <div class="text-right">
                                <p class="font-bold text-lg text-slate-800 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-slate-400">schedule</span>
                                    {{ $appointment->appointment_date->format('H:i') }}
                                </p>
                            </div>
                            
                            <!-- Status Badges -->
                            <div>
                                @if($appointment->status == 'Confirmada')
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">Confirmada</span>
                                @elseif($appointment->status == 'Pendiente')
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">Pendiente</span>
                                @elseif($appointment->status == 'Completada')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold border border-blue-200">Completada</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold border border-rose-200">Cancelada</span>
                                @endif
                            </div>

                            <!-- Actions for appointment -->
                            @if($appointment->status != 'Completada' && $appointment->status != 'Cancelada')
                                <div class="flex gap-1">
                                    <!-- Iniciar consulta (Registrar Atención) -->
                                    <a href="{{ route('history.create', ['appointment_id' => $appointment->id]) }}" 
                                       class="p-1.5 bg-primary text-white rounded-lg hover:bg-primary-container transition-all flex items-center justify-center" 
                                       title="Registrar Atención / Iniciar Consulta">
                                        <span class="material-symbols-outlined text-sm">rate_review</span>
                                    </a>
                                    
                                    @if($appointment->status == 'Pendiente')
                                        <!-- Confirmar Cita -->
                                        <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Confirmada">
                                            <button type="submit" class="p-1.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all flex items-center justify-center" title="Confirmar Cita">
                                                <span class="material-symbols-outlined text-sm">check</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">
                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">hotel_class</span>
                        <p class="text-sm font-semibold">No hay citas agendadas para el día de hoy.</p>
                        <a href="{{ route('appointments.index') }}" class="text-primary font-bold text-xs mt-2 inline-block hover:underline">+ Agendar Primera Cita</a>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Acciones Rápidas (Bento Bottom) -->
        <div class="space-y-4">
            <h4 class="text-base font-bold text-slate-800">Acciones Rápidas</h4>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Abrir modal de paciente -->
                <button @click="openPatientModal = true" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">person_add</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Registrar Paciente</span>
                </button>
                
                <!-- Agendar Cita -->
                <a href="{{ route('appointments.index') }}" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">event</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Agendar Cita</span>
                </a>
                
                <!-- Ver agenda -->
                <a href="{{ route('appointments.index') }}" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">view_agenda</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Ver Agenda</span>
                </a>
                
                <!-- Historial Clínico (Ver pacientes) -->
                <a href="{{ route('patients.index') }}" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">history</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Historial Clínico</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Pacientes Recientes & Extras -->
    <div class="col-span-12 lg:col-span-4 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm h-full flex flex-col">
            <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">patient_list</span>
                    Pacientes Recientes
                </h4>
                <a class="text-primary font-bold text-xs hover:underline" href="{{ route('patients.index') }}">Ver todos</a>
            </div>
            
            <div class="p-6 space-y-6 flex-1">
                @forelse($recentPatients as $patient)
                    <div class="flex items-center justify-between group cursor-pointer hover:bg-slate-50 p-2 rounded-lg transition-colors">
                        <a href="{{ route('patients.show', $patient->id) }}" class="flex items-center gap-3 flex-1 min-w-0">
                            <!-- Patient initials avatar -->
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold text-sm">
                                {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                            </div>
                            <div class="truncate">
                                <p class="font-bold text-sm text-slate-700 group-hover:text-primary transition-colors truncate">
                                    {{ $patient->full_name }}
                                </p>
                                <p class="text-xs text-slate-500">Doc: {{ $patient->document_number }}</p>
                            </div>
                        </a>
                        <p class="text-xs text-slate-400 whitespace-nowrap pl-2">
                            {{ $patient->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center p-8 text-slate-400">
                        <span class="material-symbols-outlined text-3xl mb-2 text-slate-300">person_off</span>
                        <p class="text-xs font-semibold">No hay pacientes registrados.</p>
                    </div>
                @endforelse
            </div>
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
                        <input type="text" name="first_name" id="first_name" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Juan">
                    </div>
                    <!-- Last Name -->
                    <div class="space-y-1">
                        <label for="last_name" class="block text-xs font-bold text-slate-700">Apellido(s) *</label>
                        <input type="text" name="last_name" id="last_name" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Pérez">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Document Type -->
                    <div class="space-y-1">
                        <label for="document_type" class="block text-xs font-bold text-slate-700">Tipo Doc *</label>
                        <select name="document_type" id="document_type" required 
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
                        <input type="text" name="document_number" id="document_number" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="12345678">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div class="space-y-1">
                        <label for="phone" class="block text-xs font-bold text-slate-700">Celular / Teléfono</label>
                        <input type="text" name="phone" id="phone" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="3112223344">
                    </div>
                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-xs font-bold text-slate-700">Correo Electrónico</label>
                        <input type="email" name="email" id="email" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="juan@correo.com">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Birth Date -->
                    <div class="space-y-1 col-span-1">
                        <label for="birth_date" class="block text-xs font-bold text-slate-700">Fecha Nac.</label>
                        <input type="date" name="birth_date" id="birth_date" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                    </div>
                    <!-- Gender -->
                    <div class="space-y-1">
                        <label for="gender" class="block text-xs font-bold text-slate-700">Género</label>
                        <select name="gender" id="gender" 
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
                        <select name="blood_type" id="blood_type" 
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
                    <input type="text" name="address" id="address" 
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
