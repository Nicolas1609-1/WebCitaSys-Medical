<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'WebCitaSys - Dashboard Médico')</title>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-variant": "#dde2f3",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#79f7ea",
                        "secondary": "#006a63",
                        "on-background": "#161c27",
                        "on-primary-fixed": "#001d37",
                        "tertiary-container": "#6f757c",
                        "tertiary-fixed": "#dde3eb",
                        "surface-tint": "#0061a5",
                        "primary-container": "#2178c3",
                        "surface-container-highest": "#dde2f3",
                        "surface": "#f9f9ff",
                        "surface-dim": "#d4daea",
                        "surface-container-low": "#f1f3ff",
                        "on-secondary-container": "#007169",
                        "secondary-fixed-dim": "#5adace",
                        "outline": "#717782",
                        "secondary-container": "#79f7ea",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#414751",
                        "primary-fixed": "#d2e4ff",
                        "on-tertiary-fixed-variant": "#41474e",
                        "primary-fixed-dim": "#9fcaff",
                        "surface-container-high": "#e3e8f9",
                        "on-tertiary-container": "#fcfcff",
                        "on-error": "#ffffff",
                        "surface-bright": "#f9f9ff",
                        "primary": "#005ea1",
                        "on-primary-fixed-variant": "#00497e",
                        "on-secondary-fixed": "#00201d",
                        "background": "#f9f9ff",
                        "on-error-container": "#93000a",
                        "surface-container-lowest": "#ffffff",
                        "inverse-on-surface": "#ecf0ff",
                        "on-surface": "#161c27",
                        "tertiary": "#565d63",
                        "error-container": "#ffdad6",
                        "inverse-primary": "#9fcaff",
                        "tertiary-fixed-dim": "#c1c7cf",
                        "on-primary-container": "#fdfcff",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#161c22",
                        "surface-container": "#e8eeff",
                        "inverse-surface": "#2a303d",
                        "on-secondary-fixed-variant": "#00504a",
                        "outline-variant": "#c0c7d3",
                        "on-secondary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "sidebar-width": "260px",
                        "sidebar-collapsed": "72px",
                        "base": "4px",
                        "gutter": "16px",
                        "container-margin": "24px",
                        "card-padding": "20px"
                    },
                    "fontFamily": {
                        "display-lg": ["Hanken Grotesk"],
                        "body-md": ["Manrope"],
                        "body-lg": ["Manrope"],
                        "headline-md-mobile": ["Hanken Grotesk"],
                        "body-sm": ["Manrope"],
                        "headline-sm": ["Hanken Grotesk"],
                        "headline-md": ["Hanken Grotesk"],
                        "label-md": ["Manrope"]
                    },
                    "fontSize": {
                        "display-lg": ["30px", {"lineHeight": "38px", "fontWeight": "700"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md-mobile": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "body-sm": ["12px", {"lineHeight": "16px", "fontWeight": "400"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["13px", {"lineHeight": "18px", "letterSpacing": "0.02em", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        body {
            background-color: #f9f9ff;
            color: #161c27;
            font-family: 'Manrope', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease-in-out;
        }
        .glass-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
    </style>
    
    <!-- Alpine JS for Micro-Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-body-md text-on-surface">

    <!-- Sidebar Navigation (Desktop) -->
    <aside class="hidden md:flex flex-col h-screen fixed left-0 top-0 z-40 w-[260px] bg-inverse-surface text-surface-variant shadow-lg">
        <div class="p-6">
            <h1 class="text-headline-md font-bold text-white mb-8 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-fixed text-3xl">local_hospital</span>
                WebCitaSys
            </h1>
            <nav class="space-y-2">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ request()->routeIs('dashboard') ? 'bg-primary text-white font-bold' : 'text-surface-variant hover:text-white hover:bg-white/10' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-body-md">Dashboard</span>
                </a>
                
                <!-- Pacientes Link -->
                <a href="{{ route('patients.index') }}" class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ request()->routeIs('patients.*') ? 'bg-primary text-white font-bold' : 'text-surface-variant hover:text-white hover:bg-white/10' }}">
                    <span class="material-symbols-outlined">groups</span>
                    <span class="text-body-md">Pacientes</span>
                </a>
                
                <!-- Citas / Agenda Link -->
                <a href="{{ route('appointments.index') }}" class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ request()->routeIs('appointments.*') ? 'bg-primary text-white font-bold' : 'text-surface-variant hover:text-white hover:bg-white/10' }}">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span class="text-body-md">Agenda y Citas</span>
                </a>

                <!-- Registrar Atención Directo -->
                <a href="{{ route('history.create') }}" class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ request()->routeIs('history.create') ? 'bg-primary text-white font-bold' : 'text-surface-variant hover:text-white hover:bg-white/10' }}">
                    <span class="material-symbols-outlined">rate_review</span>
                    <span class="text-body-md">Registrar Atención</span>
                </a>
                
                <!-- Reportes Link -->
                <a href="{{ route('reports.index') }}" class="flex items-center gap-4 rounded-lg py-3 px-6 transition-all {{ request()->routeIs('reports.*') ? 'bg-primary text-white font-bold' : 'text-surface-variant hover:text-white hover:bg-white/10' }}">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <span class="text-body-md">Reportes</span>
                </a>
            </nav>
        </div>
        
        <!-- User Info Bottom Sidebar -->
        <div class="mt-auto p-6 border-t border-outline-variant/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'Dr', 4, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm text-white truncate">{{ Auth::user()->name ?? 'Dr. Smith' }}</p>
                    <p class="text-xs text-surface-variant truncate">{{ Auth::user()->doctor->specialty ?? 'Especialista' }}</p>
                </div>
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-surface-variant hover:text-error transition-colors">
                        <span class="material-symbols-outlined text-xl">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="md:ml-[260px] min-h-screen pb-20 md:pb-8">
        
        <!-- TopAppBar -->
        <header class="fixed top-0 left-0 md:left-[260px] right-0 h-16 bg-white z-30 flex justify-between items-center px-6 shadow-sm border-b border-outline-variant/10">
            <div class="flex items-center gap-4">
                <h2 class="font-display-lg text-xl md:text-2xl font-bold text-primary">
                    @yield('header_title', 'Panel Principal')
                </h2>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Search bar (Web) -->
                <form action="{{ route('patients.index') }}" method="GET" class="hidden lg:flex items-center bg-surface-container-low px-4 py-1.5 rounded-full gap-2 border border-outline-variant/40">
                    <span class="material-symbols-outlined text-outline" data-icon="search">search</span>
                    <input name="search" class="bg-transparent border-none focus:ring-0 text-sm w-64" placeholder="Buscar paciente por cédula o nombre..." type="text"/>
                </form>
                
                <!-- Notifications icon -->
                <div class="relative cursor-pointer">
                    <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-error text-white text-[9px] flex items-center justify-center rounded-full font-bold">2</span>
                </div>
                
                <!-- User Profile Photo/Initial -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-on-surface">{{ Auth::user()->name ?? 'Dr. Carlos Mendoza' }}</p>
                        <p class="text-xs text-on-surface-variant">Bienvenido</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-container text-primary flex items-center justify-center font-bold border-2 border-primary-fixed">
                        {{ strtoupper(substr(Auth::user()->name ?? 'D', 4, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Canvas Content -->
        <div class="mt-20 px-6">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-secondary-fixed text-on-secondary-container rounded-xl border border-secondary/20 flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <span class="material-symbols-outlined text-secondary">check_circle</span>
                    <p class="text-sm font-semibold flex-1">{{ session('success') }}</p>
                    <button @click="show = false" class="hover:opacity-70">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-error-container text-on-error-container rounded-xl border border-error/20" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-symbols-outlined text-error">error</span>
                        <p class="text-sm font-bold flex-1">Por favor corrige los siguientes errores:</p>
                        <button @click="show = false" class="hover:opacity-70">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                    <ul class="list-disc pl-8 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Yield Content -->
            @yield('content')
            
        </div>
    </main>

    <!-- Bottom Navigation (Mobile View) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-40 flex justify-around items-center h-16 bg-white border-t border-outline-variant/30 shadow-[0_-2px_10px_rgba(0,0,0,0.04)] rounded-t-xl">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center text-sm {{ request()->routeIs('dashboard') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-[10px]">Inicio</span>
        </a>
        <a href="{{ route('patients.index') }}" class="flex flex-col items-center justify-center text-sm {{ request()->routeIs('patients.*') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">groups</span>
            <span class="text-[10px]">Pacientes</span>
        </a>
        <a href="{{ route('appointments.index') }}" class="flex flex-col items-center justify-center text-sm {{ request()->routeIs('appointments.*') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="text-[10px]">Citas</span>
        </a>
        <a href="{{ route('history.create') }}" class="flex flex-col items-center justify-center text-sm {{ request()->routeIs('history.create') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="text-[10px]">Atención</span>
        </a>
        <a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center text-sm {{ request()->routeIs('reports.*') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">bar_chart</span>
            <span class="text-[10px]">Reportes</span>
        </a>
        <!-- Simple Form for Mobile Logout -->
        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="flex flex-col items-center justify-center text-sm text-on-surface-variant">
            <span class="material-symbols-outlined">logout</span>
            <span class="text-[10px]">Salir</span>
        </a>
    </nav>

</body>
</html>
