@extends('layouts.app')

@section('title')
    Ficha Clínica - {{ $patient->full_name }}
@endsection

@section('header_title')
    Ficha Clínica
@endsection

@section('content')
<div class="space-y-6">
    
    <!-- Action Header -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <a href="{{ route('patients.index') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado de pacientes
        </a>
        
        <a href="{{ route('history.create', ['patient_id' => $patient->id]) }}" 
           class="px-5 py-2.5 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-xl transition-all shadow-md flex items-center gap-2 self-start sm:self-auto">
            <span class="material-symbols-outlined text-sm">rate_review</span>
            Registrar Nueva Atención
        </a>
    </div>

    <!-- Main Grid Split -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Column: Patient Personal Profile card -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            <div class="glass-card bg-white rounded-xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                <!-- Top banner accent -->
                <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
                
                <div class="text-center pb-6 border-b border-slate-100 mt-2">
                    <div class="w-20 h-20 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold text-3xl mx-auto mb-4 border border-primary/10">
                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $patient->full_name }}</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-1">{{ $patient->document_type }} Nº {{ $patient->document_number }}</p>
                </div>

                <div class="py-6 space-y-4 text-sm border-b border-slate-100">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 mb-2">Datos Fisiológicos</h4>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-3 rounded-lg text-center">
                            <p class="text-xs text-slate-400">Edad</p>
                            <p class="font-bold text-slate-800 text-base">{{ $patient->age }} años</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-lg text-center">
                            <p class="text-xs text-slate-400">Tipo Sangre</p>
                            <p class="font-bold text-primary text-base">{{ $patient->blood_type ?? 'Rh N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Género:</span>
                        <span class="font-semibold text-slate-800">{{ $patient->gender ?? 'No especificado' }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">F. Nacimiento:</span>
                        <span class="font-semibold text-slate-800">{{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                </div>

                <div class="pt-6 space-y-3 text-sm">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 mb-2">Información de Contacto</h4>
                    
                    <div class="flex items-center gap-3 py-1">
                        <span class="material-symbols-outlined text-slate-400 text-lg">call</span>
                        <span class="text-slate-700 font-medium">{{ $patient->phone ?? 'Sin celular' }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3 py-1">
                        <span class="material-symbols-outlined text-slate-400 text-lg">mail</span>
                        <span class="text-slate-700 font-medium truncate max-w-[200px]" title="{{ $patient->email }}">{{ $patient->email ?? 'Sin correo' }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3 py-1">
                        <span class="material-symbols-outlined text-slate-400 text-lg">location_on</span>
                        <span class="text-slate-700 font-medium text-xs">{{ $patient->address ?? 'Sin dirección registrada' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Link List -->
            <div class="glass-card bg-white rounded-xl p-6 shadow-sm">
                <h4 class="font-bold text-sm text-slate-800 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                    Citas Programadas
                </h4>
                <div class="space-y-3 text-xs">
                    @forelse($patient->appointments as $appt)
                        <div class="p-3 bg-slate-50 rounded-lg flex justify-between items-center border border-slate-100">
                            <div>
                                <p class="font-bold text-slate-700">{{ $appt->appointment_date->format('d/m/Y - H:i') }}</p>
                                <p class="text-slate-500">{{ $appt->doctor->full_name }}</p>
                            </div>
                            <span class="px-2 py-0.5 font-bold rounded-full {{ $appt->status == 'Completada' ? 'bg-blue-100 text-blue-800' : ($appt->status == 'Confirmada' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $appt->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-400 text-center py-2 font-medium">No registra citas programadas.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Right Column: Chronological Medical consultations history -->
        <div class="col-span-12 lg:col-span-8 space-y-6">
            
            <div class="glass-card bg-white rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history_edu</span>
                    Historial de Consultas Médicas
                </h3>
                
                @forelse($patient->clinicalRecords as $record)
                    <div class="relative pl-8 pb-10 border-l-2 border-slate-100 last:pb-0 last:border-l-0">
                        <!-- Bullet indicator dot -->
                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-primary text-white rounded-full flex items-center justify-center shadow">
                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        </div>
                        
                        <!-- Consultation Block -->
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200/50 space-y-4">
                            <!-- Header info -->
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 pb-3 border-b border-slate-200/60">
                                <div>
                                    <h4 class="font-bold text-base text-slate-800 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-slate-500">medical_services</span>
                                        Consulta Clínica
                                    </h4>
                                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Atendido por: <span class="text-primary font-bold">{{ $record->doctor->full_name }}</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-700">{{ $record->record_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-400">{{ $record->record_date->format('h:i A') }}</p>
                                </div>
                            </div>
                            
                            <!-- Vitals values row -->
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 bg-white p-3 rounded-lg border border-slate-100 text-center">
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Peso</p>
                                    <p class="font-bold text-slate-800">{{ $record->weight ? $record->weight . ' kg' : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Talla</p>
                                    <p class="font-bold text-slate-800">{{ $record->height ? $record->height . ' cm' : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Temp.</p>
                                    <p class="font-bold text-slate-800">{{ $record->temperature ? $record->temperature . ' °C' : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">P. Art.</p>
                                    <p class="font-bold text-slate-800">{{ $record->blood_pressure ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">F. Card.</p>
                                    <p class="font-bold text-slate-800">{{ $record->heart_rate ? $record->heart_rate . ' lpm' : 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <!-- Symptoms & Diagnosis -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
                                <div>
                                    <h5 class="font-bold text-xs uppercase text-slate-400 mb-1">Síntomas / Motivo</h5>
                                    <p class="bg-white p-3 rounded-lg border border-slate-100 min-h-[60px] leading-relaxed">{{ $record->symptoms }}</p>
                                </div>
                                <div>
                                    <h5 class="font-bold text-xs uppercase text-slate-400 mb-1">Diagnóstico</h5>
                                    <p class="bg-white p-3 rounded-lg border border-slate-100 min-h-[60px] leading-relaxed">{{ $record->diagnosis }}</p>
                                </div>
                            </div>
                            
                            <!-- Treatment & Prescription -->
                            @if($record->treatment || $record->prescription)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700 pt-2">
                                    @if($record->treatment)
                                        <div>
                                            <h5 class="font-bold text-xs uppercase text-slate-400 mb-1">Tratamiento / Indicaciones</h5>
                                            <p class="bg-white p-3 rounded-lg border border-slate-100 min-h-[60px] leading-relaxed">{{ $record->treatment }}</p>
                                        </div>
                                    @endif
                                    @if($record->prescription)
                                        <div>
                                            <h5 class="font-bold text-xs uppercase text-slate-400 mb-1">Receta Médica / Prescripción</h5>
                                            <div class="bg-white p-3 rounded-lg border border-slate-100 min-h-[60px] leading-relaxed font-mono text-xs whitespace-pre-line text-slate-800 border-l-4 border-primary bg-primary/5">{{ $record->prescription }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-500">
                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">assignment_late</span>
                        <p class="text-sm font-semibold">Este paciente aún no registra consultas médicas.</p>
                        <a href="{{ route('history.create', ['patient_id' => $patient->id]) }}" class="text-primary font-bold text-xs mt-2 inline-block hover:underline">+ Registrar Primera Consulta</a>
                    </div>
                @endforelse
                
            </div>
            
        </div>
        
    </div>

</div>
@endsection
