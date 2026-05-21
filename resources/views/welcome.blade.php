<!DOCTYPE html>
<html class="light scroll-smooth" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>WebCitaSys - Sistema de Gestión Médica</title>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#005ea1",
                        "primary-container": "#2178c3",
                        "surface": "#f9f9ff",
                        "inverse-surface": "#2a303d",
                        "on-surface": "#161c27",
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #f9f9ff;
            color: #161c27;
        }
        .font-display {
            font-family: 'Hanken Grotesk', sans-serif;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }
        .gradient-bg {
            background: radial-gradient(circle at 10% 20%, rgba(33, 120, 195, 0.05) 0%, rgba(255, 255, 255, 0) 90%),
                        radial-gradient(circle at 90% 80%, rgba(0, 94, 161, 0.03) 0%, rgba(255, 255, 255, 0) 90%);
        }
        .hero-shape {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex flex-col antialiased selection:bg-primary/20 selection:text-primary">

    <!-- Header Navbar -->
    <header class="glass-header fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center shadow-md shadow-primary/20 group-hover:scale-105 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl font-bold">local_hospital</span>
                </div>
                <div class="leading-none">
                    <span class="text-xl font-extrabold font-display tracking-tight text-slate-900">WebCita<span class="text-primary">Sys</span></span>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Control Clínico</p>
                </div>
            </a>

            <!-- Nav Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#caracteristicas" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Características</a>
                <a href="#estadisticas" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Impacto</a>
                <a href="#seguridad" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Seguridad y Soporte</a>
            </nav>

            <!-- Access CTAs -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-xl shadow-md shadow-primary/10 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">dashboard</span>
                        Ir al Panel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2.5 text-sm font-bold text-slate-700 hover:text-primary transition-colors">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex px-5 py-2.5 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-xl shadow-md shadow-primary/10 hover:shadow-lg active:scale-95 transition-all items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">person_add</span>
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center flex-1">
        <!-- Hero Text -->
        <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-blue-50 border border-blue-100 rounded-full text-primary text-xs font-bold tracking-wide uppercase">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                Gestión Clínica Inteligente
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold font-display tracking-tight text-slate-900 leading-tight">
                Control absoluto de tu <span class="text-primary bg-clip-text">Agenda Médica</span>
            </h1>
            
            <p class="text-base md:text-lg text-slate-500 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                Simplifica el agendamiento de citas, previene cruces de horarios de forma automática, gestiona historias clínicas con un solo clic y visualiza reportes analíticos avanzados. Todo desde una plataforma moderna diseñada para profesionales de la salud.
            </p>
            
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl active:scale-[0.99] transition-all flex items-center justify-center gap-2 text-base">
                        <span class="material-symbols-outlined">dashboard</span>
                        Acceder al Panel Médico
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl active:scale-[0.99] transition-all flex items-center justify-center gap-2 text-base group">
                        <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform">login</span>
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all flex items-center justify-center gap-2 text-base">
                        Crear Cuenta Gratis
                    </a>
                @endauth
            </div>

            <div class="pt-6 flex items-center justify-center lg:justify-start gap-6 text-slate-400">
                <span class="flex items-center gap-1.5 text-xs font-semibold">
                    <span class="material-symbols-outlined text-primary text-base">verified_user</span> Cumplimiento Médico
                </span>
                <span class="flex items-center gap-1.5 text-xs font-semibold">
                    <span class="material-symbols-outlined text-primary text-base">cloud_done</span> Nube Encriptada
                </span>
            </div>
        </div>

        <!-- Hero Graphical Mockup Dashboard representation -->
        <div class="lg:col-span-6 flex justify-center lg:justify-end relative">
            <div class="hero-shape absolute -top-8 -left-8 w-72 h-72 bg-primary/5 rounded-full blur-3xl -z-10"></div>
            <div class="hero-shape absolute -bottom-8 -right-8 w-72 h-72 bg-blue-400/5 rounded-full blur-3xl -z-10"></div>
            
            <!-- Dashboard Mockup Frame -->
            <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden relative transition-transform hover:scale-[1.01] duration-300">
                <!-- Browser top bar decoration -->
                <div class="h-10 bg-slate-50 border-b border-slate-100 px-4 flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                    </div>
                    <div class="bg-white border border-slate-200/60 rounded px-12 py-0.5 text-[9px] font-semibold text-slate-400 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[10px]">lock</span>
                        webcitasys.com/dashboard
                    </div>
                    <div class="w-4"></div>
                </div>

                <!-- Mockup Content -->
                <div class="p-5 space-y-4 bg-slate-50/50">
                    <!-- Fake Top bar -->
                    <div class="flex justify-between items-center bg-white p-3.5 rounded-xl border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                DR
                            </div>
                            <div>
                                <h4 class="text-[11px] font-bold text-slate-700 leading-tight">Dr. Carlos Mendoza</h4>
                                <p class="text-[9px] text-slate-400 font-semibold leading-tight">Médico General</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded text-[9px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Activo
                        </div>
                    </div>

                    <!-- Fake widgets grid -->
                    <div class="grid grid-cols-2 gap-3.5">
                        <!-- Agenda Widget -->
                        <div class="bg-white p-3.5 rounded-xl border border-slate-100 shadow-sm space-y-2.5">
                            <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px] text-primary">calendar_month</span> Agenda Hoy
                            </h5>
                            <div class="space-y-1.5">
                                <div class="p-2 bg-slate-50 border border-slate-100 rounded-lg flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] font-extrabold text-slate-700">Juan Pérez</p>
                                        <p class="text-[8px] text-slate-400">Chequeo General</p>
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-600 bg-slate-200/50 px-1.5 py-0.5 rounded">08:00</span>
                                </div>
                                <div class="p-2 bg-blue-50/40 border border-blue-100/50 rounded-lg flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] font-extrabold text-primary">Marta Gómez</p>
                                        <p class="text-[8px] text-blue-500">Cardiología</p>
                                    </div>
                                    <span class="text-[9px] font-bold text-primary bg-primary/10 px-1.5 py-0.5 rounded">09:30</span>
                                </div>
                            </div>
                        </div>

                        <!-- Real-time Stats Widget -->
                        <div class="bg-white p-3.5 rounded-xl border border-slate-100 shadow-sm space-y-2.5">
                            <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px] text-primary">trending_up</span> Resumen
                            </h5>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-[10px]">
                                    <span class="text-slate-500 font-semibold">Total Pacientes</span>
                                    <span class="font-extrabold text-slate-700">142</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full" style="width: 70%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] pt-1">
                                    <span class="text-slate-500 font-semibold">Citas Completadas</span>
                                    <span class="font-extrabold text-emerald-600">89%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: 89%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scheduling conflict banner representation (Zero Conflict!) -->
                    <div class="bg-primary text-white p-3 rounded-xl shadow-md shadow-primary/10 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-base">verified</span>
                        </div>
                        <div>
                            <h5 class="text-[10px] font-bold leading-tight">Módulo de Citas Optimizado</h5>
                            <p class="text-[8px] text-blue-100 leading-tight">Validación automática de horarios para evitar agendas duplicadas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="caracteristicas" class="bg-white py-24 px-6 border-y border-slate-100">
        <div class="max-w-7xl mx-auto space-y-12">
            <!-- Header Features -->
            <div class="text-center max-w-3xl mx-auto space-y-4">
                <span class="text-xs font-extrabold text-primary uppercase tracking-widest">¿Qué ofrece WebCitaSys?</span>
                <h2 class="text-3xl md:text-4xl font-extrabold font-display text-slate-900 tracking-tight">
                    Una herramienta integrada para optimizar tu consulta
                </h2>
                <p class="text-sm md:text-base text-slate-500">
                    Diseñado específicamente para médicos y clínicas que requieren un control rápido, fluido y libre de errores administrativos.
                </p>
            </div>

            <!-- Bento Grid of Features -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pt-4">
                <!-- Feature 1: Agenda Inteligente -->
                <div class="bg-[#f9f9ff] hover:bg-white rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold">calendar_today</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Agenda Inteligente</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">
                        Visualiza tus compromisos diarios en un cronograma limpio y interactivo. El sistema valida automáticamente la hora seleccionada para asegurar que ningún médico tenga cruces de horarios.
                    </p>
                </div>

                <!-- Feature 2: Historias Clínicas -->
                <div class="bg-[#f9f9ff] hover:bg-white rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold">clinical_notes</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Expedientes Digitales</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">
                        Registra diagnósticos, recetas, antecedentes de salud y notas de tratamiento por paciente de forma organizada, segura y siempre al alcance de tu mano en la nube.
                    </p>
                </div>

                <!-- Feature 3: Reportes Avanzados -->
                <div class="bg-[#f9f9ff] hover:bg-white rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold">bar_chart</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Reportes de Rendimiento</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">
                        Obtén gráficos detallados sobre las citas completadas, especialidades más concurridas, y el volumen de pacientes activos para tomar decisiones clínicas basadas en datos reales.
                    </p>
                </div>

                <!-- Feature 4: Gestión de Pacientes -->
                <div class="bg-[#f9f9ff] hover:bg-white rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold">groups</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Control de Pacientes</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">
                        Almacena números de documento, tipos de sangre, teléfonos y correos. Registra nuevos pacientes al instante a través de nuestro modal dinámico rápido.
                    </p>
                </div>

                <!-- Feature 5: Notificaciones Activas -->
                <div class="bg-[#f9f9ff] hover:bg-white rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold">notifications_active</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Alertas en Tiempo Real</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">
                        El sistema integra notificaciones internas sobre citas de última hora registradas para mañana y diagnósticos que requieran validación urgente.
                    </p>
                </div>

                <!-- Feature 6: Responsive Premium -->
                <div class="bg-[#f9f9ff] hover:bg-white rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold">devices</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Diseño Multiplataforma</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">
                        Visualización optimizada y responsiva. Trabaja desde tu ordenador de escritorio en el consultorio, o revisa tu cronograma desde tu tablet o smartphone en casa.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="estadisticas" class="py-20 px-6 max-w-7xl mx-auto w-full">
        <div class="bg-inverse-surface rounded-3xl text-white p-8 md:p-12 relative overflow-hidden shadow-xl">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent opacity-60"></div>
            
            <div class="relative z-10 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-y divide-slate-700/40 lg:divide-y-0 lg:divide-x divide-slate-700/40">
                <!-- Stat 1 -->
                <div class="pt-4 lg:pt-0 space-y-1.5">
                    <h4 class="text-3xl md:text-5xl font-extrabold font-display tracking-tight text-white">99.9%</h4>
                    <p class="text-[11px] md:text-xs font-bold uppercase tracking-wider text-slate-400">Disponibilidad del Sistema</p>
                </div>
                <!-- Stat 2 -->
                <div class="pt-4 lg:pt-0 space-y-1.5">
                    <h4 class="text-3xl md:text-5xl font-extrabold font-display tracking-tight text-white">+10k</h4>
                    <p class="text-[11px] md:text-xs font-bold uppercase tracking-wider text-slate-400">Citas Procesadas</p>
                </div>
                <!-- Stat 3 -->
                <div class="pt-4 lg:pt-0 space-y-1.5">
                    <h4 class="text-3xl md:text-5xl font-extrabold font-display tracking-tight text-white">0%</h4>
                    <p class="text-[11px] md:text-xs font-bold uppercase tracking-wider text-slate-400">Cruces de Horarios</p>
                </div>
                <!-- Stat 4 -->
                <div class="pt-4 lg:pt-0 space-y-1.5">
                    <h4 class="text-3xl md:text-5xl font-extrabold font-display tracking-tight text-white">+500</h4>
                    <p class="text-[11px] md:text-xs font-bold uppercase tracking-wider text-slate-400">Historias Clínicas Guardadas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section: Security & Trust -->
    <section id="seguridad" class="bg-slate-50 py-24 px-6 border-t border-slate-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-extrabold text-primary uppercase tracking-widest">Seguridad Médica</span>
                <h2 class="text-3xl font-extrabold font-display text-slate-900 tracking-tight leading-tight">
                    Tus datos clínicos encriptados y protegidos
                </h2>
                <p class="text-sm md:text-base text-slate-500 leading-relaxed">
                    Entendemos la delicadeza y confidencialidad que requiere el manejo de datos de salud de tus pacientes. WebCitaSys implementa encriptación de datos en tránsito y en reposo para garantizar la máxima seguridad en todos los registros médicos del sistema.
                </p>
                <ul class="space-y-3 pt-2 text-sm text-slate-600 font-medium">
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span> Backups diarios automáticos
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span> Accesos restringidos bajo autenticación fuerte
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span> Cumplimiento estricto de confidencialidad
                    </li>
                </ul>
            </div>
            
            <div class="lg:col-span-6 flex justify-center">
                <!-- Graphic badge representation -->
                <div class="p-8 bg-white border border-slate-200/60 rounded-3xl shadow-lg w-full max-w-sm space-y-6 text-center">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto shadow-inner">
                        <span class="material-symbols-outlined text-3xl font-bold">shield</span>
                    </div>
                    <div class="space-y-2">
                        <h4 class="font-extrabold text-slate-800 text-lg">Certificado de Nube Segura</h4>
                        <p class="text-xs text-slate-400">Protección garantizada en todas tus operaciones diarias.</p>
                    </div>
                    <div class="border-t border-slate-100 pt-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        WebCitaSys Standard Security
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pre-Footer CTA -->
    <section class="bg-primary text-white py-16 px-6 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-transparent"></div>
        <div class="max-w-4xl mx-auto space-y-6 relative z-10">
            <h3 class="text-3xl font-extrabold font-display tracking-tight">¿Listo para transformar la gestión de tu consultorio?</h3>
            <p class="text-sm md:text-base text-blue-100 max-w-xl mx-auto">
                Crea tu cuenta de forma gratuita en pocos minutos y experimenta una forma más inteligente y segura de atender a tus pacientes.
            </p>
            <div class="pt-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-white text-primary hover:bg-slate-50 font-bold rounded-xl shadow-lg active:scale-95 transition-all inline-flex items-center gap-2 text-base">
                        <span class="material-symbols-outlined">dashboard</span>
                        Acceder al Panel
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-primary hover:bg-slate-50 font-bold rounded-xl shadow-lg active:scale-95 transition-all inline-flex items-center gap-2 text-base">
                        <span class="material-symbols-outlined">person_add</span>
                        Comenzar Ahora Gratis
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-inverse-surface text-slate-400 py-12 px-6 border-t border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-lg font-bold">local_hospital</span>
                </div>
                <span class="text-lg font-extrabold font-display tracking-tight text-white">WebCita<span class="text-primary">Sys</span></span>
            </div>

            <!-- Footer Text -->
            <p class="text-xs text-center md:text-right font-medium text-slate-500">
                &copy; {{ date('Y') }} WebCitaSys. Todos los derechos reservados. Diseñado para la eficiencia en el sector salud.
            </p>
        </div>
    </footer>

</body>
</html>
