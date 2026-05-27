@extends('layouts.app')

@section('title', 'WebCitaSys - Editar Usuario')
@section('header_title', 'Editar Usuario')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
            <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">edit</span>
                Editar: {{ $user->name }}
            </h4>
        </div>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nombre Completo *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Nueva Contraseña (dejar vacío para mantener)</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Rol *</label>
                <select name="role_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-bold text-sm">Cancelar</a>
                <button type="submit" class="px-5 py-2 bg-primary text-white font-bold rounded-xl shadow-md text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
