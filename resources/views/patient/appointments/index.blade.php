@extends('layouts.app')

@section('title', 'WebCitaSys - Mis Citas')
@section('header_title', 'Mis Citas')

@section('content')
<div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
    <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
        <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">event_note</span>
            Historial de Citas
        </h4>
    </div>
    <div class="divide-y divide-slate-100">
        @forelse($appointments as $appointment)
        <div class="p-6 hover:bg-slate-50 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold">
                        {{ strtoupper(substr($appointment->doctor?->first_name ?? 'M', 0, 1) . substr($appointment->doctor?->last_name ?? 'D', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-base text-slate-800">{{ $appointment->doctor?->full_name ?? 'Médico asignado' }}</p>
                        <p class="text-sm text-slate-500">{{ $appointment->doctor?->specialty ?? 'Especialidad' }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $appointment->reason }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 justify-end">
                    <div class="text-right">
                        <p class="font-bold text-sm text-slate-700">{{ $appointment->appointment_date->format('d/m/Y') }}</p>
                        <p class="text-sm text-slate-500">{{ $appointment->appointment_date->format('H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-bold rounded-full
                        @if($appointment->status == 'Confirmada') bg-emerald-100 text-emerald-800
                        @elseif($appointment->status == 'Pendiente') bg-amber-100 text-amber-800
                        @elseif($appointment->status == 'Completada') bg-blue-100 text-blue-800
                        @else bg-rose-100 text-rose-800 @endif">
                        {{ $appointment->status }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center text-slate-500">
            <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">calendar_month</span>
            <p class="text-lg font-bold text-slate-600">No tienes citas registradas</p>
            <p class="text-sm text-slate-400 mt-1">Las citas que agendes aparecerán aquí.</p>
        </div>
        @endforelse
    </div>

    @if($appointments->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $appointments->links() }}
    </div>
    @endif
</div>
@endsection
