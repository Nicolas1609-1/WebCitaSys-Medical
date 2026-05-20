<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Iniciar Sesión - WebCitaSys</title>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-surface flex items-center justify-center min-h-screen p-4 font-sans" style="font-family: 'Manrope', sans-serif;">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        
        <!-- Header Section -->
        <div class="bg-inverse-surface p-8 text-center text-white relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-transparent opacity-50"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-primary-container text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg border border-primary/20">
                    <span class="material-symbols-outlined text-4xl">local_hospital</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight font-display" style="font-family: 'Hanken Grotesk', sans-serif;">WebCitaSys</h1>
                <p class="text-slate-300 text-sm mt-1">Medical Management System</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('login') }}" method="POST" class="p-8 space-y-5">
            @csrf
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Hanken Grotesk', sans-serif;">Acceso al Panel Médico</h2>
                <p class="text-slate-500 text-xs mt-1">Ingresa tus credenciales para acceder al sistema.</p>
            </div>

            <!-- Email Field -->
            <div class="space-y-1">
                <label for="email" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Correo Electrónico</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" 
                       class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                       placeholder="ejemplo@webcitasys.com">
                <div class="min-h-[22px] mt-1">
                    @error('email')
                        <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                    @else
                        @if(old('email') === null && $errors->any())
                            <span class="text-xs text-slate-900 font-semibold block leading-tight">El correo electrónico es obligatorio.</span>
                        @endif
                    @enderror
                </div>
                <p class="text-[11px] text-slate-400">Prueba con: <span class="font-bold text-primary">doctor@webcitasys.com</span></p>
            </div>

            <!-- Password Field -->
            <div class="space-y-1" x-data="{ showPass: false }">
                <label for="password" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Contraseña</label>
                <div class="relative">
                    <input :type="showPass ? 'text' : 'password'" name="password" id="password" required 
                           class="w-full bg-transparent border-0 border-b border-slate-200 pl-0 pr-8 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                           placeholder="••••••••">
                    <button type="button" @click="showPass = !showPass" class="absolute right-0 top-2.5 text-slate-400 hover:text-slate-600">
                        <span class="material-symbols-outlined text-xl" x-text="showPass ? 'visibility' : 'visibility_off'"></span>
                    </button>
                </div>
                <div class="min-h-[22px] mt-1">
                    @error('password')
                        <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                    @else
                        @if($errors->any())
                            <span class="text-xs text-slate-900 font-semibold block leading-tight">La contraseña es obligatoria.</span>
                        @endif
                    @enderror
                </div>
                <p class="text-[11px] text-slate-400">Contraseña de prueba: <span class="font-bold text-primary">password</span></p>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-sm pt-2">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary/20 border-slate-300">
                    Recordarme
                </label>
                <a href="#" class="text-primary font-semibold hover:underline">¿Olvidaste tu contraseña?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-bold transition-all shadow-md active:scale-[0.99] flex items-center justify-center gap-2 mt-4">
                <span class="material-symbols-outlined text-lg">login</span>
                Iniciar Sesión
            </button>

            <!-- Registration Link -->
            <p class="text-center text-sm text-slate-600 pt-2">
                ¿No tienes una cuenta médica? 
                <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Regístrate aquí</a>
            </p>
        </form>

    </div>

</body>
</html>
