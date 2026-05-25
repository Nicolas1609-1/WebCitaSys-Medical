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
        [x-cloak] { display: none !important; }
    </style>

    <!-- Alpine JS for Micro-Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-body-md text-on-surface">

    @auth
        @include('layouts.partials.sidebar')
    @endauth

    <!-- Main Content Area -->
    <main class="@auth md:ml-[260px] @endauth min-h-screen pb-20 md:pb-8">

        @auth
        <!-- TopAppBar -->
        <header class="fixed top-0 left-0 @auth md:left-[260px] @endauth right-0 h-16 bg-white z-30 flex justify-between items-center px-6 shadow-sm border-b border-outline-variant/10">
            <div class="flex items-center gap-4">
                <h2 class="font-display-lg text-xl md:text-2xl font-bold text-primary">
                    @yield('header_title', 'Panel Principal')
                </h2>
            </div>

            <div class="flex items-center gap-6">
                <!-- Notifications Component -->
                <div class="relative"
                     x-data="{
                         openNotifications: false,
                         notifications: [],
                         init() {
                             const stored = localStorage.getItem('webcitasys_notifications');
                             if (stored) {
                                 this.notifications = JSON.parse(stored);
                             } else {
                                 this.notifications = [
                                     { id: 1, type: 'cita', title: 'Nueva Cita Agendada', text: 'El paciente Carlos Mendoza agendó para mañana a las 09:00 AM.', time: 'Hace 10 minutos', read: false },
                                     { id: 2, type: 'urgente', title: 'Diagnóstico Pendiente', text: 'La atención de Juan Duarte requiere validación de diagnóstico completo.', time: 'Hace 2 horas', read: false }
                                 ];
                                 this.save();
                             }
                         },
                         save() { localStorage.setItem('webcitasys_notifications', JSON.stringify(this.notifications)); },
                         get badgeCount() { return this.notifications.filter(n => !n.read).length; },
                         markAllAsRead() { this.notifications.forEach(n => n.read = true); this.save(); },
                         deleteNotification(id) { this.notifications = this.notifications.filter(n => n.id !== id); this.save(); },
                         clearAll() { this.notifications = []; this.save(); }
                     }">
                    <button @click="openNotifications = !openNotifications" class="relative cursor-pointer focus:outline-none flex items-center justify-center p-1.5 rounded-full hover:bg-slate-100 transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant text-[26px]">notifications</span>
                        <span x-show="badgeCount > 0" x-text="badgeCount" class="absolute top-1 right-1 w-4 h-4 bg-error text-white text-[9px] flex items-center justify-center rounded-full font-bold"></span>
                    </button>

                    <div x-show="openNotifications"
                         @click.outside="openNotifications = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 overflow-hidden"
                         x-cloak>

                        <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <span class="font-bold text-slate-800 text-sm">Notificaciones</span>
                            <div class="flex gap-2">
                                <button x-show="badgeCount > 0" @click="markAllAsRead()" class="text-xs font-bold text-primary hover:underline">Leer todas</button>
                                <span x-show="badgeCount > 0 && notifications.length > 0" class="text-slate-300 text-xs">•</span>
                                <button x-show="notifications.length > 0" @click="clearAll()" class="text-xs font-bold text-red-600 hover:underline">Borrar todas</button>
                            </div>
                        </div>

                        <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-50">
                            <template x-if="notifications.length === 0">
                                <div class="p-8 text-center flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-2.5">
                                        <span class="material-symbols-outlined text-2xl">check_circle</span>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">¡Al día!</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">No tienes notificaciones pendientes.</p>
                                </div>
                            </template>

                            <template x-for="n in notifications" :key="n.id">
                                <div class="p-3.5 hover:bg-slate-50/70 transition-colors flex gap-3 text-left relative group"
                                     :class="n.read ? 'opacity-60 bg-white' : 'bg-blue-50/20'">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                                         :class="n.type === 'cita' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600'">
                                        <span class="material-symbols-outlined text-base" x-text="n.type === 'cita' ? 'event_note' : 'warning'"></span>
                                    </div>
                                    <div class="flex-1 min-w-0 pr-4">
                                        <p class="text-xs font-bold text-slate-800 leading-normal" x-text="n.title"></p>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-normal" x-text="n.text"></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <p class="text-[9px] text-slate-400 font-semibold" x-text="n.time"></p>
                                            <span x-show="!n.read" class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                        </div>
                                    </div>
                                    <button @click="deleteNotification(n.id)"
                                            class="absolute right-2 top-3 text-slate-300 hover:text-red-600 rounded p-1 transition-colors focus:outline-none">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="px-4 py-2 border-t border-slate-100 text-center bg-slate-50/30">
                            <span class="text-xs text-slate-400 font-semibold">Fin de notificaciones</span>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-on-surface">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-on-surface-variant">{{ Auth::user()->getRoleDisplayName() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-container text-primary flex items-center justify-center font-bold border-2 border-primary-fixed">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>
        @endauth

        <!-- Page Canvas Content -->
        <div class="@auth mt-20 @endauth px-6">

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

    @auth
        @include('layouts.partials.mobile-nav')
    @endauth

</body>
</html>
