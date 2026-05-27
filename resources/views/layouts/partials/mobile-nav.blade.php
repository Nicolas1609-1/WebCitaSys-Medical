@php
    $user = Auth::user();
    $role = $user->role?->slug;
    $isActive = fn($route) => request()->routeIs($route) ? 'text-primary font-bold' : 'text-on-surface-variant';

    $mobileItems = match ($role) {
        'admin' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
            ['route' => 'patients.*',       'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'appointments.*',   'icon' => 'calendar_today', 'label' => 'Agenda'],
            ['route' => 'history.create',   'icon' => 'rate_review',    'label' => 'Atención'],
            ['route' => 'reports.*',        'icon' => 'bar_chart',      'label' => 'Reportes'],
        ],
        'doctor' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
            ['route' => 'patients.*',       'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'appointments.*',   'icon' => 'calendar_today', 'label' => 'Agenda'],
            ['route' => 'history.create',   'icon' => 'rate_review',    'label' => 'Atención'],
        ],
        'receptionist' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
            ['route' => 'patients.*',       'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'appointments.*',   'icon' => 'calendar_today', 'label' => 'Agenda'],
        ],
        'financial' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
            ['route' => 'reports.*',        'icon' => 'bar_chart',      'label' => 'Reportes'],
        ],
        'support' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
            ['route' => 'admin.system.*',   'icon' => 'bug_report',     'label' => 'Monitoreo'],
        ],
        'patient' => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
            ['route' => 'patient.appointments', 'icon' => 'event_note', 'label' => 'Citas'],
            ['route' => 'patient.history',  'icon' => 'medical_services','label' => 'Historial'],
        ],
        default => [
            ['route' => 'dashboard',        'icon' => 'dashboard',      'label' => 'Inicio'],
        ],
    };
@endphp

<nav class="md:hidden fixed bottom-0 left-0 w-full z-40 flex justify-around items-center h-16 bg-white border-t border-outline-variant/30 shadow-[0_-2px_10px_rgba(0,0,0,0.04)] rounded-t-xl">
    @foreach($mobileItems as $item)
    <a href="{{ route(str_replace('.*', '.index', $item['route'])) }}"
       class="flex flex-col items-center justify-center text-sm {{ $isActive($item['route']) }}">
        <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
        <span class="text-[10px]">{{ $item['label'] }}</span>
    </a>
    @endforeach

    <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="flex flex-col items-center justify-center text-sm text-on-surface-variant">
        <span class="material-symbols-outlined">logout</span>
        <span class="text-[10px]">Salir</span>
    </a>
</nav>
