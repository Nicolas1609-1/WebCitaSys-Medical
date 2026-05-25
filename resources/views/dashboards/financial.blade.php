@extends('layouts.app')

@section('title', 'WebCitaSys - Panel Financiero')
@section('header_title', 'Panel Financiero')

@section('content')
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-primary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Citas del Mes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $monthlyAppointments }}</h3>
            </div>
            <div class="p-3 bg-primary-fixed rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">event</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-secondary bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Completadas Este Mes</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $completedThisMonth }}</h3>
            </div>
            <div class="p-3 bg-secondary-fixed rounded-xl text-secondary">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-surface-tint bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Total Completadas</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $totalCompleted }}</h3>
            </div>
            <div class="p-3 bg-surface-container-high rounded-xl text-primary">
                <span class="material-symbols-outlined text-2xl">done_all</span>
            </div>
        </div>
    </div>
    <div class="glass-card p-card-padding rounded-xl border-l-4 border-error bg-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-on-surface-variant font-semibold tracking-wider text-xs uppercase mb-1">Canceladas</p>
                <h3 class="text-3xl font-bold font-display text-slate-800">{{ $canceledCount }}</h3>
            </div>
            <div class="p-3 bg-error-container rounded-xl text-error">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
        </div>
    </div>
</section>

<div class="bento-grid">
    <div class="col-span-12 lg:col-span-6 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">bar_chart</span>
                    Citas por Estado
                </h4>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                @foreach($statusCounts as $status => $count)
                <div class="text-center p-4 rounded-xl bg-slate-50">
                    <p class="text-3xl font-bold font-display text-slate-800">{{ $count }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $status }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">stethoscope</span>
                    Consultas por Especialidad
                </h4>
            </div>
            <div class="p-6 space-y-4">
                @forelse($specialtyStats as $specialty => $count)
                <div class="flex items-center justify-between">
                    <p class="text-sm font-bold text-slate-700">{{ $specialty }}</p>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-slate-100 rounded-full h-2">
                            @php $max = max($specialtyStats->max(), 1); @endphp
                            <div class="bg-primary h-2 rounded-full" style="width: {{ ($count / $max) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-600 w-8 text-right">{{ $count }}</span>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center">Sin datos disponibles.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-6 space-y-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">trending_up</span>
                    Citas Mensuales {{ now()->year }}
                </h4>
            </div>
            <div class="p-6">
                <div class="space-y-2">
                    @foreach($monthlyStats as $month => $count)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-600 w-20">{{ $month }}</span>
                        <div class="flex-1 bg-slate-100 rounded-full h-4">
                            @php $mMax = max($monthlyStats) ?: 1; @endphp
                            <div class="bg-secondary h-4 rounded-full flex items-center justify-end px-2" style="width: {{ ($count / $mMax) * 100 }}%">
                                <span class="text-[10px] text-white font-bold">{{ $count }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('reports.index') }}" class="glass-card p-5 rounded-xl bg-white flex-1 flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">assessment</span>
                </div>
                <span class="text-sm font-bold text-slate-700">Ver Reportes</span>
            </a>
            <button onclick="window.print()" class="glass-card p-5 rounded-xl bg-white flex-1 flex flex-col items-center gap-2 hover:bg-primary/5 group transition-all text-center">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">file_download</span>
                </div>
                <span class="text-sm font-bold text-slate-700">Exportar</span>
            </button>
        </div>
    </div>
</div>
@endsection
