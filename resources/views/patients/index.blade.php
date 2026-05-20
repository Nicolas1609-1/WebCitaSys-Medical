@extends('layouts.app')

@section('title', 'WebCitaSys - Registro de Pacientes')
@section('header_title', 'Pacientes')

@section('content')
<div class="space-y-6" x-data="{ openRegisterModal: false }">
    
    <!-- Top Filter/Search Bar Panel -->
    <div class="glass-card bg-white rounded-xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Search Form -->
        <form action="{{ route('patients.index') }}" method="GET" class="flex-1 max-w-lg flex items-center gap-2">
            <div class="relative flex-1">
                <span class="material-symbols-outlined text-slate-400 absolute left-3 top-2.5">search</span>
                <input type="text" name="search" value="{{ $search }}"
                       class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm" 
                       placeholder="Buscar por cédula o nombre de paciente...">
            </div>
            
            <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-xl transition-all shadow-md">
                Buscar
            </button>
            
            @if($search)
                <a href="{{ route('patients.index') }}" class="px-3 py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-bold rounded-xl transition-all">
                    Limpiar
                </a>
            @endif
        </form>

        <!-- Register button trigger -->
        <button @click="openRegisterModal = true" class="px-5 py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-xl transition-all shadow-md flex items-center gap-2 text-sm self-start md:self-auto">
            <span class="material-symbols-outlined">person_add</span>
            Registrar Paciente
        </button>
    </div>

    <!-- Patients List Table Card -->
    <div class="glass-card bg-white rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant/20 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">patient_list</span>
                Directorio General de Pacientes
            </h3>
            <span class="text-xs font-semibold px-3 py-1 bg-slate-100 rounded-full text-slate-600">Total: {{ $patients->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/30">
                        <th class="px-6 py-4">Paciente</th>
                        <th class="px-6 py-4">Identificación</th>
                        <th class="px-6 py-4">Contacto</th>
                        <th class="px-6 py-4 text-center">Edad / Rh</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-fixed-dim text-primary flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $patient->full_name }}</p>
                                        <p class="text-xs text-slate-400">Registrado el {{ $patient->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700">{{ $patient->document_type }}</span> {{ $patient->document_number }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-700 font-medium">{{ $patient->phone ?? 'Sin teléfono' }}</p>
                                <p class="text-xs text-slate-400 truncate max-w-xs">{{ $patient->email ?? 'Sin correo' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <p class="font-bold text-slate-700">{{ $patient->age }} años</p>
                                <span class="px-2 py-0.5 text-xs bg-primary/10 text-primary font-bold rounded-full">{{ $patient->blood_type ?? 'Rh' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <!-- Registrar Atención médica direct -->
                                    <a href="{{ route('history.create', ['patient_id' => $patient->id]) }}" 
                                       class="px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-container transition-all flex items-center gap-1"
                                       title="Registrar Atención">
                                        <span class="material-symbols-outlined text-sm">rate_review</span>
                                        Atender
                                    </a>

                                    <!-- Ver Ficha Clínica -->
                                    <a href="{{ route('patients.show', $patient->id) }}" 
                                       class="px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-all flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">assignment_ind</span>
                                        Ficha Clínica
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">person_off</span>
                                <p class="text-sm font-semibold">No se encontraron pacientes que coincidan con la búsqueda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $patients->appends(['search' => $search])->links() }}
            </div>
        @endif
    </div>

    <!-- Alpine Modal: Registrar Paciente Completo -->
    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black/50 p-4" 
         x-show="openRegisterModal" 
         x-transition
         x-cloak>
        <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100" @click.away="openRegisterModal = false">
            <div class="bg-inverse-surface p-6 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-fixed">person_add</span>
                    Registrar Nuevo Paciente
                </h3>
                <button @click="openRegisterModal = false" class="text-white hover:text-slate-300 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form action="{{ route('patients.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div class="space-y-1">
                        <label for="first_name" class="block text-xs font-bold text-slate-700">Nombre(s) *</label>
                        <input type="text" name="first_name" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Juan">
                    </div>
                    <!-- Last Name -->
                    <div class="space-y-1">
                        <label for="last_name" class="block text-xs font-bold text-slate-700">Apellido(s) *</label>
                        <input type="text" name="last_name" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Pérez">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Document Type -->
                    <div class="space-y-1">
                        <label for="document_type" class="block text-xs font-bold text-slate-700">Tipo Doc *</label>
                        <select name="document_type" required 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="TI">Tarjeta Identidad</option>
                            <option value="Pasaporte">Pasaporte</option>
                            <option value="RC">Registro Civil</option>
                        </select>
                    </div>
                    <!-- Document Number -->
                    <div class="space-y-1 col-span-2">
                        <label for="document_number" class="block text-xs font-bold text-slate-700">Nº de Documento *</label>
                        <input type="text" name="document_number" required 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="12345678">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div class="space-y-1">
                        <label for="phone" class="block text-xs font-bold text-slate-700">Celular / Teléfono</label>
                        <input type="text" name="phone" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="3112223344">
                    </div>
                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-xs font-bold text-slate-700">Correo Electrónico</label>
                        <input type="email" name="email" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="juan@correo.com">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Birth Date -->
                    <div class="space-y-1">
                        <label for="birth_date" class="block text-xs font-bold text-slate-700">Fecha Nac.</label>
                        <input type="date" name="birth_date" 
                               class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                    </div>
                    <!-- Gender -->
                    <div class="space-y-1">
                        <label for="gender" class="block text-xs font-bold text-slate-700">Género</label>
                        <select name="gender" 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">Selecciona...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <!-- Blood Type -->
                    <div class="space-y-1">
                        <label for="blood_type" class="block text-xs font-bold text-slate-700">Rh / Sangre</label>
                        <select name="blood_type" 
                                class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm">
                            <option value="">RH...</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-1">
                    <label for="address" class="block text-xs font-bold text-slate-700">Dirección</label>
                    <input type="text" name="address" 
                           class="w-full px-3 py-1.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm" placeholder="Calle 100 #15-30, Bogotá">
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="openRegisterModal = false" 
                            class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-bold transition-all text-sm">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 bg-primary hover:bg-primary-container text-white font-bold rounded-xl transition-all shadow-md text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">check</span>
                        Guardar Paciente
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
