@extends('layouts.app')

@section('title', 'WebCitaSys - Panel Médico')
@section('header_title', 'Panel Médico')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-1">Bienvenido, Dr. {{ $doctor->first_name ?? '' }}</h2>
    <p class="text-sm text-slate-500">{{ now()->format('l, d \d\e F \d\e Y') }}</p>
</div>

<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-primary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas del Día</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $todayCount }}</h3>
                @if($todayCount > 0)
                <p class="text-xs text-slate-500 mt-1">{{ $completedTodayCount }} completadas</p>
                @endif
            </div>
            <div class="p-3 bg-primary-fixed rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">event_note</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-warning bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Pacientes Pendientes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $pendingCount }}</h3>
                <p class="text-xs text-slate-500 mt-1">requieren atención</p>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                <span class="material-symbols-outlined text-2xl">pending_actions</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-secondary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Próximas Consultas</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $upcomingCount }}</h3>
                <p class="text-xs text-slate-500 mt-1">en los próximos 7 días</p>
            </div>
            <div class="p-3 bg-secondary-fixed rounded-xl text-secondary">
                <span class="material-symbols-outlined text-2xl">calendar_clock</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-info bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Notificaciones</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $notificationsCount }}</h3>
                <p class="text-xs text-slate-500 mt-1">sin leer</p>
            </div>
            <div class="p-3 bg-sky-50 rounded-xl text-sky-600">
                <span class="material-symbols-outlined text-2xl">notifications</span>
            </div>
        </div>
    </div>
</section>

<div class="bento-grid">
    <div class="col-span-12 lg:col-span-7 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">today</span>
                        Agenda Rápida
                    </h4>
                    @if($todayCount > 0)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $todayCount }} cita(s) programada(s) para hoy</p>
                    @endif
                </div>
                <a href="{{ route('appointments.index') }}" class="text-primary font-bold text-sm hover:underline">Ver agenda completa</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($todayAppointments as $appointment)
                <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold shrink-0">
                            {{ strtoupper(substr($appointment->patient->first_name ?? '', 0, 1) . substr($appointment->patient->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-sm text-slate-800 truncate">{{ $appointment->patient?->full_name ?? 'Paciente' }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $appointment->reason }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="font-bold text-sm text-slate-700">{{ $appointment->appointment_date->format('H:i') }}</span>
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full
                            @if($appointment->status == 'Confirmada') bg-emerald-100 text-emerald-800
                            @elseif($appointment->status == 'Pendiente') bg-amber-100 text-amber-800
                            @elseif($appointment->status == 'Completada') bg-blue-100 text-blue-800
                            @else bg-rose-100 text-rose-800 @endif">
                            {{ $appointment->status }}
                        </span>
                        @if($appointment->status !== 'Completada' && $appointment->status !== 'Cancelada')
                        <a href="{{ route('history.create', ['appointment_id' => $appointment->id]) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-container hover:text-primary transition-all">
                            <span class="material-symbols-outlined text-sm">rate_review</span>
                            Iniciar consulta
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">event_busy</span>
                    <p class="text-sm font-semibold">No tienes citas programadas para hoy.</p>
                    <p class="text-xs text-slate-400 mt-1">Las nuevas citas aparecerán aquí automáticamente.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
                <div class="p-5 border-b border-outline-variant/30 bg-slate-50/50">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">group</span>
                        Pacientes Recientes
                    </h4>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentPatients as $patient)
                    <div class="p-3 hover:bg-slate-50 transition-colors flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                            {{ strtoupper(substr($patient->first_name ?? '', 0, 1) . substr($patient->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-700 truncate">{{ $patient->full_name }}</p>
                            <p class="text-xs text-slate-400">{{ $patient->appointments()->where('doctor_id', $doctor->id)->latest()->first()?->appointment_date->format('d/m/Y') ?? 'Sin citas previas' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-slate-400 text-sm">Sin pacientes recientes.</div>
                    @endforelse
                </div>
            </div>

            <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
                <div class="p-5 border-b border-outline-variant/30 bg-slate-50/50">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">check_circle</span>
                        Consultas Finalizadas Hoy
                    </h4>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($completedAppointments as $appointment)
                    <div class="p-3 hover:bg-slate-50 transition-colors flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs shrink-0">
                            {{ strtoupper(substr($appointment->patient->first_name ?? '', 0, 1) . substr($appointment->patient->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-700 truncate">{{ $appointment->patient?->full_name ?? 'Paciente' }}</p>
                            <p class="text-xs text-slate-400">{{ $appointment->appointment_date->format('H:i') }}</p>
                        </div>
                        <span class="text-xs text-emerald-600 font-bold">Completada</span>
                    </div>
                    @empty
                    <div class="p-6 text-center text-slate-400 text-sm">Sin consultas finalizadas hoy.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-5 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">pending_actions</span>
                    Próximas Citas
                </h4>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($nextAppointments as $appointment)
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                            {{ strtoupper(substr($appointment->patient->first_name ?? '', 0, 1) . substr($appointment->patient->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm text-slate-700 truncate">{{ $appointment->patient?->full_name ?? 'Paciente' }}</p>
                            <p class="text-xs text-slate-500">{{ $appointment->appointment_date->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full
                            @if($appointment->status == 'Confirmada') bg-emerald-100 text-emerald-800
                            @else bg-amber-100 text-amber-800 @endif">
                            {{ $appointment->status }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1 ml-12">{{ Str::limit($appointment->reason, 50) }}</p>
                </div>
                @empty
                <div class="p-6 text-center text-slate-400 text-sm">No hay próximas citas pendientes.</div>
                @endforelse
            </div>
        </div>

        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">notifications</span>
                    Notificaciones
                </h4>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($notifications as $notification)
                <div class="p-3 hover:bg-slate-50 transition-colors">
                    <p class="text-sm text-slate-700">{{ $notification->message }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @empty
                <div class="p-6 text-center text-slate-400 text-sm">
                    <span class="material-symbols-outlined text-3xl text-slate-300 mb-1">notifications_off</span>
                    <p class="text-sm">No tienes notificaciones.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Últimos Registros Clínicos
                </h4>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentRecords as $record)
                <div class="p-3 hover:bg-slate-50 transition-colors">
                    <p class="text-sm font-bold text-slate-700">{{ $record->patient?->full_name ?? 'Paciente' }}</p>
                    <p class="text-xs text-slate-500">{{ $record->diagnosis ? Str::limit($record->diagnosis, 60) : 'Sin diagnóstico' }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $record->created_at->format('d/m/Y H:i') }}</p>
                </div>
                @empty
                <div class="p-6 text-center text-slate-400 text-sm">Sin registros recientes.</div>
                @endforelse
            </div>
        </div>

        <a href="{{ route('patients.index') }}"
           class="flex items-center justify-center gap-2 w-full p-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-container hover:text-primary transition-all shadow-sm">
            <span class="material-symbols-outlined">person_search</span>
            Ver todos los pacientes
        </a>
    </div>
</div>
@endsection