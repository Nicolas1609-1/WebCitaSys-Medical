@extends('layouts.app')

@section('title', 'WebCitaSys - Panel Recepción')
@section('header_title', 'Panel de Recepción')

@section('content')
<section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-primary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas Hoy</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $todayAppointmentsCount }}</h3>
            </div>
            <div class="p-3 bg-primary-fixed rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">calendar_today</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-error bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Pendientes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $pendingCount }}</h3>
            </div>
            <div class="p-3 bg-error-container rounded-xl text-error">
                <span class="material-symbols-outlined text-2xl">pending_actions</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-secondary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Pacientes Registrados</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $totalPatients }}</h3>
            </div>
            <div class="p-3 bg-secondary-fixed rounded-xl text-secondary">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
        </div>
    </div>
</section>

<div class="bento-grid" x-data="{ openPatientModal: false }">
    <div class="col-span-12 lg:col-span-7 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50 flex justify-between items-center">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">event_note</span>
                    Agenda de Hoy
                </h4>
                <a href="{{ route('appointments.index') }}" class="text-primary font-bold text-sm hover:underline">Agenda completa</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($todayAppointments as $appointment)
                <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold">
                            {{ strtoupper(substr($appointment->patient->first_name ?? '', 0, 1) . substr($appointment->patient->last_name ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $appointment->patient?->full_name ?? 'Paciente' }}</p>
                            <p class="text-xs text-slate-500">{{ $appointment->doctor?->full_name ?? 'Médico' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-end">
                        <span class="font-bold text-sm text-slate-700">{{ $appointment->appointment_date->format('H:i') }}</span>
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full
                            @if($appointment->status == 'Confirmada') bg-emerald-100 text-emerald-800
                            @elseif($appointment->status == 'Pendiente') bg-amber-100 text-amber-800
                            @elseif($appointment->status == 'Completada') bg-blue-100 text-blue-800
                            @else bg-rose-100 text-rose-800 @endif">
                            {{ $appointment->status }}
                        </span>
                        @if($appointment->status == 'Pendiente')
                        <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="Confirmada">
                            <button type="submit" class="p-1.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600" title="Confirmar">
                                <span class="material-symbols-outlined text-sm">check</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">event_busy</span>
                    <p class="text-sm font-semibold">No hay citas para hoy.</p>
                    <span class="text-primary font-bold text-xs mt-2 inline-block cursor-pointer" @click="openPatientModal = true">+ Agendar nueva cita</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-5 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">patient_list</span>
                    Pacientes Recientes
                </h4>
            </div>
            <div class="p-4 space-y-3">
                @forelse($recentPatients as $patient)
                <a href="{{ route('patients.show', $patient->id) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold text-sm">
                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 group-hover:text-primary truncate">{{ $patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $patient->document_number }}</p>
                    </div>
                </a>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">No hay pacientes registrados.</p>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <button @click="openPatientModal = true" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">person_add</span>
                </div>
                <span class="text-sm font-bold text-slate-700">Registrar Paciente</span>
            </button>
            <a href="{{ route('patients.index') }}" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <span class="text-sm font-bold text-slate-700">Buscar Paciente</span>
            </a>
        </div>
    </div>

    <!-- Quick Patient Registration Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black/50 p-4"
         x-show="openPatientModal"
         x-transition
         x-cloak>
        <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl" @click.away="openPatientModal = false">
            <div class="bg-inverse-surface p-6 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-fixed">person_add</span>
                    Registrar Nuevo Paciente
                </h3>
                <button @click="openPatientModal = false" class="text-white hover:text-slate-300">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="{{ route('patients.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nombre(s) *</label>
                        <input type="text" name="first_name" required class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm" placeholder="Juan">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Apellido(s) *</label>
                        <input type="text" name="last_name" required class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm" placeholder="Pérez">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Tipo Doc *</label>
                        <select name="document_type" required class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm">
                            <option value="CC">CC</option>
                            <option value="TI">TI</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="block text-xs font-bold text-slate-700">Nº Documento *</label>
                        <input type="text" name="document_number" required class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm" placeholder="12345678">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Celular</label>
                        <input type="text" name="phone" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm" placeholder="3112223344">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Correo</label>
                        <input type="email" name="email" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm" placeholder="juan@correo.com">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Fecha Nac.</label>
                        <input type="date" name="birth_date" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Género</label>
                        <select name="gender" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm">
                            <option value="">Selecciona...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Rh / Sangre</label>
                        <select name="blood_type" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm">
                            <option value="">RH...</option>
                            @foreach(['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $bt)
                            <option value="{{ $bt }}">{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Dirección</label>
                    <input type="text" name="address" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm" placeholder="Calle 100 #15-30, Bogotá">
                </div>
                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="openPatientModal = false" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-bold text-sm">Cancelar</button>
                    <button type="submit" class="px-5 py-2 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-md text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">check</span>
                        Guardar Paciente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
