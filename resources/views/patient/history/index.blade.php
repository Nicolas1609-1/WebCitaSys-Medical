@extends('layouts.app')

@section('title', 'WebCitaSys - Mi Historial Clínico')
@section('header_title', 'Mi Historial Clínico')

@section('content')
<div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
    <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
        <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">medical_services</span>
            Historial Médico Completo
        </h4>
    </div>
    <div class="divide-y divide-slate-100">
        @forelse($records as $record)
        <div class="p-6 hover:bg-slate-50 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">description</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-base text-slate-800">Dr. {{ $record->doctor?->full_name ?? 'Médico' }}</p>
                            <p class="text-sm text-slate-500">{{ $record->doctor?->specialty ?? 'Especialidad' }}</p>
                        </div>
                        <p class="text-sm text-slate-400 whitespace-nowrap">{{ $record->record_date->format('d/m/Y') }}</p>
                    </div>

                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                        @if($record->weight)
                        <div class="bg-slate-50 p-2 rounded-lg text-center">
                            <p class="text-xs text-slate-500">Peso</p>
                            <p class="font-bold text-sm text-slate-700">{{ $record->weight }} kg</p>
                        </div>
                        @endif
                        @if($record->height)
                        <div class="bg-slate-50 p-2 rounded-lg text-center">
                            <p class="text-xs text-slate-500">Altura</p>
                            <p class="font-bold text-sm text-slate-700">{{ $record->height }} cm</p>
                        </div>
                        @endif
                        @if($record->temperature)
                        <div class="bg-slate-50 p-2 rounded-lg text-center">
                            <p class="text-xs text-slate-500">Temperatura</p>
                            <p class="font-bold text-sm text-slate-700">{{ $record->temperature }} °C</p>
                        </div>
                        @endif
                        @if($record->blood_pressure)
                        <div class="bg-slate-50 p-2 rounded-lg text-center">
                            <p class="text-xs text-slate-500">Presión</p>
                            <p class="font-bold text-sm text-slate-700">{{ $record->blood_pressure }}</p>
                        </div>
                        @endif
                    </div>

                    @if($record->symptoms)
                    <div class="mt-3">
                        <p class="text-xs font-bold text-slate-600">Síntomas</p>
                        <p class="text-sm text-slate-600 mt-0.5">{{ $record->symptoms }}</p>
                    </div>
                    @endif

                    @if($record->diagnosis)
                    <div class="mt-2 p-3 bg-blue-50 rounded-xl">
                        <p class="text-xs font-bold text-blue-700">Diagnóstico</p>
                        <p class="text-sm text-blue-900 mt-0.5">{{ $record->diagnosis }}</p>
                    </div>
                    @endif

                    @if($record->treatment)
                    <div class="mt-2">
                        <p class="text-xs font-bold text-slate-600">Tratamiento</p>
                        <p class="text-sm text-slate-600 mt-0.5">{{ $record->treatment }}</p>
                    </div>
                    @endif

                    @if($record->prescription)
                    <div class="mt-2 p-3 bg-amber-50 rounded-xl">
                        <p class="text-xs font-bold text-amber-700">Prescripción / Fórmula</p>
                        <p class="text-sm text-amber-900 mt-0.5 whitespace-pre-line">{{ $record->prescription }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center text-slate-500">
            <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">note_alt</span>
            <p class="text-lg font-bold text-slate-600">Sin registros médicos</p>
            <p class="text-sm text-slate-400 mt-1">Tu historial médico se mostrará aquí después de tus consultas.</p>
        </div>
        @endforelse
    </div>

    @if($records->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $records->links() }}
    </div>
    @endif
</div>
@endsection
