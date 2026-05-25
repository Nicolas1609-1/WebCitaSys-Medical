@extends('layouts.app')

@section('title', 'WebCitaSys - Horarios')
@section('header_title', 'Configuración de Horarios')

@section('content')
<div class="bento-grid">
    @forelse($doctors as $doctor)
    <div class="col-span-12 lg:col-span-6">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold">
                        {{ strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-800">{{ $doctor->full_name }}</h4>
                        <p class="text-sm text-slate-500">{{ $doctor->specialty }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @php $schedules = $doctor->schedules; @endphp
                @if($schedules->isEmpty())
                <p class="text-sm text-slate-400 text-center py-4">Sin horarios configurados.</p>
                @else
                <div class="space-y-3">
                    @foreach($schedules as $schedule)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <span class="text-sm font-bold text-slate-700 capitalize">{{ $schedule->day_of_week }}</span>
                        <span class="text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        </span>
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $schedule->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $schedule->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-12 text-center py-12">
        <span class="material-symbols-outlined text-5xl text-slate-300 mb-4">schedule</span>
        <p class="text-slate-500">No hay médicos registrados en el sistema.</p>
    </div>
    @endforelse
</div>
@endsection
