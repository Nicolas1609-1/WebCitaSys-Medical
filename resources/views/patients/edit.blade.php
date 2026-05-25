@extends('layouts.app')

@section('title', 'WebCitaSys - Editar Paciente')
@section('header_title', 'Editar Paciente')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
            <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">edit</span>
                {{ $patient->full_name }}
            </h4>
        </div>
        <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Nombre(s) *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Apellido(s) *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tipo Doc *</label>
                    <select name="document_type" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                        @foreach(['CC','TI','Pasaporte','RC'] as $doc)
                        <option value="{{ $doc }}" {{ $patient->document_type == $doc ? 'selected' : '' }}>{{ $doc }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1 col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Nº Documento *</label>
                    <input type="text" name="document_number" value="{{ old('document_number', $patient->document_number) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Celular / Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Fecha Nac.</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $patient->birth_date?->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Género</label>
                    <select name="gender" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                        <option value="">Selecciona...</option>
                        <option value="Masculino" {{ $patient->gender == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ $patient->gender == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ $patient->gender == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Rh / Sangre</label>
                    <select name="blood_type" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                        <option value="">RH...</option>
                        @foreach(['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $bt)
                        <option value="{{ $bt }}" {{ $patient->blood_type == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Dirección</label>
                <input type="text" name="address" value="{{ old('address', $patient->address) }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('patients.show', $patient->id) }}" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-bold text-sm">Cancelar</a>
                <button type="submit" class="px-5 py-2 bg-primary text-white font-bold rounded-xl shadow-md text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
