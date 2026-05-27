@extends('layouts.app')

@section('title', 'WebCitaSys - Panel Administrativo')
@section('header_title', 'Panel de Administración')

@section('content')
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-primary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Pacientes Registrados</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $totalPatients }}</h3>
            </div>
            <div class="p-3 bg-primary-fixed rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
        </div>
    </div>

    <div class="glass-card p-card-padding rounded-xl border-l-4 border-secondary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas Hoy</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $todayAppointmentsCount }}</h3>
            </div>
            <div class="p-3 bg-secondary-fixed rounded-xl text-secondary">
                <span class="material-symbols-outlined text-2xl">calendar_today</span>
            </div>
        </div>
    </div>

    <div class="glass-card p-card-padding rounded-xl border-l-4 border-surface-tint bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Usuarios Activos</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $activeUsers }}</h3>
            </div>
            <div class="p-3 bg-surface-container-high rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">badge</span>
            </div>
        </div>
    </div>

    <div class="glass-card p-card-padding rounded-xl border-l-4 border-error bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas del Mes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $monthlyAppointments }}</h3>
                <p class="text-secondary text-xs mt-2">{{ $monthlyCompleted }} completadas</p>
            </div>
            <div class="p-3 bg-error-container rounded-xl text-error">
                <span class="material-symbols-outlined text-2xl">show_chart</span>
            </div>
        </div>
    </div>
</section>

<div class="bento-grid">
    <div class="col-span-12 lg:col-span-8 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">bar_chart</span>
                    Distribución de Citas por Estado
                </h4>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($statusDistribution as $status => $count)
                <div class="text-center p-4 rounded-xl bg-slate-50">
                    <p class="text-3xl font-bold font-display text-slate-800">{{ $count }}</p>
                    <p class="text-sm text-slate-500 mt-1">
                        @switch($status)
                            @case('Pendiente') Pendientes @break
                            @case('Confirmada') Confirmadas @break
                            @case('Completada') Completadas @break
                            @case('Cancelada') Canceladas @break
                            @default {{ $status }}
                        @endswitch
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.users.index') }}" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">manage_accounts</span>
                </div>
                <span class="text-sm font-bold text-slate-700">Gestionar Usuarios</span>
            </a>
            <a href="{{ route('admin.schedules.index') }}" class="glass-card p-5 rounded-xl bg-white flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <span class="text-sm font-bold text-slate-700">Configurar Horarios</span>
            </a>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person_add</span>
                    Usuarios Recientes
                </h4>
            </div>
            <div class="p-4 space-y-3">
                @forelse($recentUsers as $u)
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold text-sm">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 truncate">{{ $u->name }}</p>
                        <p class="text-xs text-slate-500">{{ $u->getRoleDisplayName() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">No hay usuarios registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
