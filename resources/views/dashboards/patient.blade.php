@extends('layouts.app')

@section('title', 'WebCitaSys - Mi Panel')
@section('header_title', 'Mi Panel de Salud')

@section('content')
<div class="mb-6">
    <div class="glass-card p-6 rounded-xl bg-white">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">{{ $patient->full_name }}</h3>
                <p class="text-sm text-slate-500">{{ $patient->document_type }}: {{ $patient->document_number }}</p>
                <p class="text-sm text-slate-500">{{ $patient->email }} {{ $patient->phone ? '| ' . $patient->phone : '' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bento-grid">
    <div class="col-span-12 lg:col-span-7 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50 flex justify-between items-center">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">event</span>
                    Próximas Citas
                </h4>
                <a href="{{ route('patient.appointments') }}" class="text-primary font-bold text-sm hover:underline">Ver todas</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($upcomingAppointments as $appointment)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary-fixed text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">calendar_month</span>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $appointment->doctor?->full_name ?? 'Médico' }}</p>
                            <p class="text-xs text-slate-500">{{ $appointment->appointment_date->format('d/m/Y H:i') }} - {{ $appointment->reason }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full
                        @if($appointment->status == 'Confirmada') bg-emerald-100 text-emerald-800
                        @else bg-amber-100 text-amber-800 @endif">
                        {{ $appointment->status }}
                    </span>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">event_busy</span>
                    <p class="text-sm font-semibold">No tienes próximas citas.</p>
                    <a href="{{ route('patient.appointments') }}" class="text-primary font-bold text-xs mt-2 inline-block hover:underline">Agendar una cita</a>
                </div>
                @endforelse
            </div>
        </div>

        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">medical_services</span>
                    Historial Médico Reciente
                </h4>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($medicalRecords as $record)
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">description</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-700">Dr. {{ $record->doctor?->full_name ?? 'Médico' }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ Str::limit($record->diagnosis, 100) }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $record->record_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">note_alt</span>
                    <p class="text-sm font-semibold">No tienes registros médicos aún.</p>
                </div>
                @endforelse
            </div>
            @if($medicalRecords->isNotEmpty())
            <div class="p-4 border-t border-slate-100 text-center">
                <a href="{{ route('patient.history') }}" class="text-primary font-bold text-sm hover:underline">Ver historial completo</a>
            </div>
            @endif
        </div>
    </div>

    <div class="col-span-12 lg:col-span-5 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">notifications</span>
                    Notificaciones
                </h4>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($unreadNotifications as $notification)
                <div class="p-4 bg-blue-50/30 hover:bg-blue-50/50 transition-colors">
                    <p class="text-sm font-bold text-slate-700">{{ $notification->title }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $notification->message }}</p>
                    <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">notifications_off</span>
                    <p class="text-sm font-semibold">No tienes notificaciones pendientes.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Citas Anteriores
                </h4>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($pastAppointments as $appointment)
                <div class="p-3 hover:bg-slate-50 transition-colors">
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-bold text-slate-700">{{ $appointment->doctor?->full_name ?? 'Médico' }}</p>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full
                            @if($appointment->status == 'Completada') bg-blue-100 text-blue-700
                            @else bg-rose-100 text-rose-700 @endif">
                            {{ $appointment->status }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500">{{ $appointment->appointment_date->format('d/m/Y H:i') }}</p>
                </div>
                @empty
                <div class="p-6 text-center text-slate-400 text-sm">Sin citas anteriores.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
