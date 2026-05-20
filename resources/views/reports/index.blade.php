@extends('layouts.app')

@section('title', 'WebCitaSys - Reportes y Estadísticas')
@section('header_title', 'Reportes')

@section('content')
<div class="space-y-6">

    <!-- KPI Summary Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card bg-white rounded-xl p-6 border-l-4 border-primary shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Pacientes</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalPatients }}</h3>
            <p class="text-xs text-secondary mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">groups</span>
                Pacientes registrados
            </p>
        </div>

        <div class="glass-card bg-white rounded-xl p-6 border-l-4 border-secondary shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Citas</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalAppointments }}</h3>
            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">calendar_month</span>
                Citas creadas en el sistema
            </p>
        </div>

        <div class="glass-card bg-white rounded-xl p-6 border-l-4 border-emerald-500 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Citas Completadas</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $statusCounts['Completada'] }}</h3>
            <p class="text-xs text-emerald-600 mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">check_circle</span>
                @if($totalAppointments > 0)
                    {{ number_format(($statusCounts['Completada'] / $totalAppointments) * 100, 1) }}% del total
                @else
                    0% del total
                @endif
            </p>
        </div>

        <div class="glass-card bg-white rounded-xl p-6 border-l-4 border-error shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Citas Canceladas</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $statusCounts['Cancelada'] }}</h3>
            <p class="text-xs text-error mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">cancel</span>
                @if($totalAppointments > 0)
                    {{ number_format(($statusCounts['Cancelada'] / $totalAppointments) * 100, 1) }}% del total
                @else
                    0% del total
                @endif
            </p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Chart 1: Appointment Status Distribution -->
        <div class="glass-card bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">donut_small</span>
                Distribución de Citas por Estado
            </h3>

            <div class="space-y-4">
                @php
                    $statusColors = [
                        'Confirmada' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'light' => 'bg-emerald-50'],
                        'Pendiente' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-700', 'light' => 'bg-amber-50'],
                        'Completada' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-50'],
                        'Cancelada' => ['bg' => 'bg-rose-500', 'text' => 'text-rose-700', 'light' => 'bg-rose-50'],
                    ];
                @endphp

                @foreach($statusCounts as $status => $count)
                    @php
                        $percentage = $totalAppointments > 0 ? ($count / $totalAppointments) * 100 : 0;
                        $colors = $statusColors[$status] ?? ['bg' => 'bg-slate-400', 'text' => 'text-slate-600', 'light' => 'bg-slate-50'];
                    @endphp
                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-slate-700 flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full {{ $colors['bg'] }}"></span>
                                {{ $status }}
                            </span>
                            <span class="font-bold {{ $colors['text'] }}">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="{{ $colors['bg'] }} h-3 rounded-full transition-all duration-700"
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach

                @if($totalAppointments == 0)
                    <p class="text-slate-400 text-center text-sm py-4 font-semibold">No hay datos de citas para mostrar.</p>
                @endif
            </div>
        </div>

        <!-- Chart 2: Attentions by Specialty -->
        <div class="glass-card bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">bar_chart</span>
                Consultas Realizadas por Especialidad
            </h3>

            @php
                $specialtyColors = [
                    'Cardiología' => 'bg-primary',
                    'Medicina General' => 'bg-secondary',
                    'Pediatría' => 'bg-amber-500',
                ];
                $maxSpecialty = max($specialtyCounts) ?: 1;
            @endphp

            <div class="flex items-end gap-4 h-48 mt-4 px-4">
                @foreach($specialtyCounts as $specialty => $count)
                    @php
                        $height = $maxSpecialty > 0 ? max(($count / $maxSpecialty) * 100, 5) : 5;
                        $color = $specialtyColors[$specialty] ?? 'bg-slate-400';
                    @endphp
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <span class="font-bold text-sm text-slate-700">{{ $count }}</span>
                        <div class="{{ $color }} w-full rounded-t-lg transition-all duration-700" style="height: {{ $height }}%"></div>
                        <p class="text-[10px] font-bold text-slate-500 text-center leading-tight">{{ $specialty }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Detail Table -->
    <div class="glass-card bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">table_chart</span>
            <h3 class="text-base font-bold text-slate-800">Resumen de Actividad del Sistema</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/30">
                        <th class="px-6 py-3">Métrica</th>
                        <th class="px-6 py-3 text-right">Valor</th>
                        <th class="px-6 py-3 text-right">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-700 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">groups</span>
                            Total Pacientes Registrados
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-800 text-base">{{ $totalPatients }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Activos</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-700 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-base">calendar_month</span>
                            Total Citas Agendadas
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-800 text-base">{{ $totalAppointments }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">Global</span>
                        </td>
                    </tr>
                    @foreach($statusCounts as $status => $count)
                        @php
                            $badgeColors = [
                                'Confirmada' => 'bg-emerald-100 text-emerald-700',
                                'Pendiente' => 'bg-amber-100 text-amber-700',
                                'Completada' => 'bg-blue-100 text-blue-700',
                                'Cancelada' => 'bg-rose-100 text-rose-700',
                            ];
                            $badge = $badgeColors[$status] ?? 'bg-slate-100 text-slate-600';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-600 pl-12">↳ Citas con estado: {{ $status }}</td>
                            <td class="px-6 py-4 text-right font-bold text-slate-700">{{ $count }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2 py-1 {{ $badge }} text-xs font-bold rounded-full">{{ $status }}</span>
                            </td>
                        </tr>
                    @endforeach
                    @foreach($specialtyCounts as $specialty => $count)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-600 flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-base">stethoscope</span>
                                Consultas en {{ $specialty }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-slate-700">{{ $count }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full">Especialidad</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
