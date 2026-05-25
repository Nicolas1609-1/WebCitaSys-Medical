@extends('layouts.app')

@section('title', 'WebCitaSys - Gestión de Usuarios')
@section('header_title', 'Gestión de Usuarios')

@section('content')
<div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm mb-6">
    <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">manage_accounts</span>
            <h4 class="text-lg font-bold text-slate-800">Usuarios del Sistema</h4>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-all text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">add</span>
                Nuevo Usuario
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre o email..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm">
        </div>
        <div class="w-full sm:w-48">
            <select name="role" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm" onchange="this.form.submit()">
                <option value="">Todos los roles</option>
                @foreach($roles as $role)
                <option value="{{ $role->slug }}" {{ $roleFilter == $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="p-4 font-bold text-slate-600">Nombre</th>
                    <th class="p-4 font-bold text-slate-600">Email</th>
                    <th class="p-4 font-bold text-slate-600">Rol</th>
                    <th class="p-4 font-bold text-slate-600 hidden md:table-cell">Registro</th>
                    <th class="p-4 font-bold text-slate-600 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-slate-600">{{ $user->email }}</td>
                    <td class="p-4">
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $user->role_badge }}">
                            {{ $user->getRoleDisplayName() }}
                        </span>
                    </td>
                    <td class="p-4 text-slate-400 text-xs hidden md:table-cell">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-primary hover:underline font-bold text-xs">Editar</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">No se encontraron usuarios.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
