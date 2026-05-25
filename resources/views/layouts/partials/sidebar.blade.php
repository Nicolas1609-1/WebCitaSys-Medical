@php
    $user = Auth::user();
    $role = $user->role?->slug;
    $isActive = fn($route) => request()->routeIs($route) ? 'bg-primary text-white font-bold' : 'text-surface-variant hover:text-white hover:bg-white/10';

    $menuItems = match ($role) {
        'admin' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
            ['route' => 'patients.*',       'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'appointments.*',   'icon' => 'calendar_month', 'label' => 'Agenda y Citas'],
            ['route' => 'history.create',   'icon' => 'rate_review',    'label' => 'Registrar Atención'],
            ['route' => 'reports.*',        'icon' => 'bar_chart',      'label' => 'Reportes'],
        ],
        'doctor' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
            ['route' => 'patients.*',       'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'appointments.*',   'icon' => 'calendar_month', 'label' => 'Mi Agenda'],
            ['route' => 'history.create',   'icon' => 'rate_review',    'label' => 'Registrar Atención'],
            ['route' => 'reports.*',        'icon' => 'bar_chart',      'label' => 'Reportes'],
        ],
        'receptionist' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
            ['route' => 'patients.*',       'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'appointments.*',   'icon' => 'calendar_month', 'label' => 'Agenda y Citas'],
        ],
        'financial' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
            ['route' => 'reports.*',        'icon' => 'bar_chart',      'label' => 'Reportes'],
        ],
        'support' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
            ['route' => 'admin.system.*',   'icon' => 'bug_report',     'label' => 'Monitoreo'],
        ],
        'patient' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
            ['route' => 'patient.appointments', 'icon' => 'event_note', 'label' => 'Mis Citas'],
            ['route' => 'patient.history',  'icon' => 'medical_services','label' => 'Mi Historial'],
        ],
        default => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Dashboard'],
        ],
    };

    $adminItems = match ($role) {
        'admin' => [
            ['route' => 'admin.users.*',    'icon' => 'manage_accounts','label' => 'Usuarios'],
            ['route' => 'admin.schedules.*','icon' => 'schedule',       'label' => 'Horarios'],
            ['route' => 'admin.system.*',   'icon' => 'monitoring',     'label' => 'Sistema'],
        ],
        default => [],
    };
@endphp

<aside class="hidden md:flex flex-col h-screen fixed left-0 top-0 z-40 w-[260px] bg-inverse-surface text-surface-variant shadow-lg">
    <div class="p-6 flex flex-col h-full">
        <h1 class="text-headline-md font-bold text-white mb-8 flex items-center gap-2 shrink-0">
            <span class="material-symbols-outlined text-primary-fixed text-3xl">local_hospital</span>
            WebCitaSys
        </h1>

        <nav class="space-y-2 flex-1 overflow-y-auto">
            @foreach($menuItems as $item)
            <a href="{{ route($item['route'] === 'patients.*' || str_contains($item['route'], '*') ? str_replace('.*', '.index', $item['route']) : $item['route']) }}"
               class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ $isActive($item['route']) }}">
                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                <span class="text-body-md">{{ $item['label'] }}</span>
            </a>
            @endforeach

            @if(!empty($adminItems))
            <div class="pt-4 mt-4 border-t border-outline-variant/20">
                <p class="text-xs text-surface-variant/50 px-6 mb-2 uppercase tracking-wider font-bold">Administración</p>
                @foreach($adminItems as $item)
                <a href="{{ route(str_replace('.*', '.index', $item['route'])) }}"
                   class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ $isActive($item['route']) }}">
                    <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                    <span class="text-body-md">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>
            @endif
        </nav>

        <div class="mt-auto pt-6 border-t border-outline-variant/10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-surface-variant truncate">{{ $user->getRoleDisplayName() }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-surface-variant hover:text-error transition-colors">
                        <span class="material-symbols-outlined text-xl">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
