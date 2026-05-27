@extends('layouts.app')

@section('title', 'WebCitaSys - Sistema')
@section('header_title', 'Monitoreo del Sistema')

@section('content')
<div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm mb-6">
    <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
        <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">history</span>
            Registro de Auditoría
        </h4>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="p-3 font-bold text-slate-600">Fecha/Hora</th>
                    <th class="p-3 font-bold text-slate-600">Usuario</th>
                    <th class="p-3 font-bold text-slate-600">Acción</th>
                    <th class="p-3 font-bold text-slate-600">Módulo</th>
                    <th class="p-3 font-bold text-slate-600 hidden lg:table-cell">Descripción</th>
                    <th class="p-3 font-bold text-slate-600 hidden lg:table-cell">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="p-3 text-slate-500 text-xs">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="p-3 text-slate-700">{{ $log->user?->name ?? 'Sistema' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full
                            @if($log->action == 'created') bg-emerald-100 text-emerald-700
                            @elseif($log->action == 'updated') bg-blue-100 text-blue-700
                            @elseif($log->action == 'deleted') bg-rose-100 text-rose-700
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="p-3 text-slate-600 capitalize">{{ $log->module }}</td>
                    <td class="p-3 text-slate-500 text-xs hidden lg:table-cell max-w-xs truncate">{{ $log->description }}</td>
                    <td class="p-3 text-slate-400 text-xs hidden lg:table-cell">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">Sin registros de auditoría.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
