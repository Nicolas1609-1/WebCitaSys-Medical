@extends('layouts.app')

@section('title', 'WebCitaSys - Mis Citas')
@section('header_title', 'Mis Citas')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <div class="lg:col-span-2">
        <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm" x-data="{
            selectedDate: '',
            minDate: new Date().toISOString().split('T')[0],
            get tomorrow() {
                const d = new Date();
                d.setDate(d.getDate() + 1);
                return d.toISOString().split('T')[0];
            }
        }">
            <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">add_circle</span>
                    Agendar Nueva Cita
                </h4>
            </div>
            <form action="{{ route('patient.appointments.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Médico *</label>
                    <select name="doctor_id" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary">
                        <option value="">Seleccionar médico</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->full_name }} - {{ $doctor->specialty }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Fecha y Hora *</label>
                    <input type="datetime-local" name="appointment_date"
                           x-model="selectedDate"
                           :min="tomorrow"
                           value="{{ old('appointment_date') }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Motivo de la Consulta *</label>
                    <textarea name="reason" rows="3" required
                              class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary"
                              placeholder="Describe brevemente el motivo de tu consulta">{{ old('reason') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-container hover:text-primary transition-all shadow-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">event</span>
                    Solicitar Cita
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-3">
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
                    <p class="text-sm text-slate-400 mt-1">Usa el formulario para agendar tu primera cita.</p>
                </div>
                @endforelse
            </div>

            @if($appointments->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $appointments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection