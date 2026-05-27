@extends('layouts.app')

@section('title', 'WebCitaSys - Panel de Soporte')
@section('header_title', 'Panel de Soporte Técnico')

@section('content')
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-primary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Eventos Hoy</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $logCountToday }}</h3>
            </div>
            <div class="p-3 bg-primary-fixed rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">today</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-secondary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Eventos del Mes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $logCountMonth }}</h3>
            </div>
            <div class="p-3 bg-secondary-fixed rounded-xl text-secondary">
                <span class="material-symbols-outlined text-2xl">date_range</span>
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
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-error bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Total Usuarios</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $totalUsers }}</h3>
            </div>
            <div class="p-3 bg-error-container rounded-xl text-error">
                <span class="material-symbols-outlined text-2xl">people</span>
            </div>
        </div>
    </div>
</section>

<div class="bento-grid">
    <div class="col-span-12 lg:col-span-5 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    Acciones del Sistema
                </h4>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm font-bold text-slate-600 mb-2">Distribución por Acción</p>
                @forelse($actionsDistribution as $action => $count)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-700 capitalize">{{ $action }}</span>
                    <span class="text-sm font-bold text-primary">{{ $count }}</span>
                </div>
                @empty
                <p class="text-sm text-slate-400">Sin datos de auditoría.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-7 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Auditoría Reciente
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="p-3 font-bold text-slate-600">Usuario</th>
                            <th class="p-3 font-bold text-slate-600">Acción</th>
                            <th class="p-3 font-bold text-slate-600">Módulo</th>
                            <th class="p-3 font-bold text-slate-600 hidden md:table-cell">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentLogs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-3 text-slate-700">{{ $log->user?->name ?? 'Sistema' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full
                                    @if($log->action == 'created') bg-emerald-100 text-emerald-700
                                    @elseif($log->action == 'updated') bg-blue-100 text-blue-700
                                    @elseif($log->action == 'deleted') bg-rose-100 text-rose-700
                                    @else bg-slate-100 text-slate-700 @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-3 text-slate-600 capitalize">{{ $log->module }}</td>
                            <td class="p-3 text-slate-400 text-xs hidden md:table-cell">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-400">Sin registros de auditoría.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
