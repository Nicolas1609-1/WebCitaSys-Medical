<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Iniciar Sesión - WebCitaSys</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
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
        body {
            background:
                linear-gradient(135deg, rgba(0,94,161,0.08) 0%, rgba(33,120,195,0.03) 50%, rgba(249,249,255,1) 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cpath d='M40 20v40M20 40h40' stroke='%23005ea1' stroke-width='1.5' opacity='0.06'/%3E%3C/svg%3E");
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 font-sans" style="font-family: 'Manrope', sans-serif;">

    <div class="w-full max-w-md bg-white/95 backdrop-blur rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-inverse-surface to-slate-800 p-6 text-center text-white relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-transparent opacity-60"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 bg-primary-container text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg border border-primary/20">
                    <span class="material-symbols-outlined text-3xl">local_hospital</span>
                </div>
                <h1 class="text-xl font-bold tracking-tight font-display" style="font-family: 'Hanken Grotesk', sans-serif;">WebCitaSys</h1>
                <p class="text-slate-300 text-xs mt-0.5">Medical Management System</p>
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" novalidate
              x-data="{
                  errors: { email: '', password: '' },
                  showPass: false,
                  validateForm(e) {
                      let hasError = false;
                      this.errors = { email: '', password: '' };
                      const email = document.getElementById('email').value.trim();
                      if (!email) { this.errors.email = 'El correo es obligatorio.'; hasError = true; }
                      else if (!email.includes('@')) { this.errors.email = 'Correo inválido.'; hasError = true; }
                      if (!document.getElementById('password').value) { this.errors.password = 'La contraseña es obligatoria.'; hasError = true; }
                      if (hasError) e.preventDefault();
                  }
              }"
              @submit="validateForm($event)"
              class="p-6 space-y-4">
            @csrf

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">check_circle</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="text-center">
                <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Hanken Grotesk', sans-serif;">Acceso al Panel Médico</h2>
            </div>

            <div>
                <label for="email" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Correo Electrónico</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                       class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-sm placeholder-slate-300 transition-colors"
                       placeholder="ejemplo@webcitasys.com">
                <div class="min-h-[20px]">
                    <span x-show="errors.email" class="text-[10px] text-red-600 font-semibold" x-text="errors.email" x-cloak></span>
                    @error('email')<span class="text-[10px] text-red-600 font-semibold">{{ $message }}</span>@enderror
                </div>
            </div>

            <div>
                <label for="password" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Contraseña</label>
                <div class="relative">
                    <input :type="showPass ? 'text' : 'password'" name="password" id="password" required
                           class="w-full bg-transparent border-0 border-b border-slate-200 pl-0 pr-8 py-2 focus:ring-0 focus:border-primary text-sm placeholder-slate-300 transition-colors"
                           placeholder="••••••••">
                    <button type="button" @click="showPass = !showPass" class="absolute right-0 top-2 text-slate-400 hover:text-slate-600">
                        <span class="material-symbols-outlined text-lg" x-text="showPass ? 'visibility' : 'visibility_off'"></span>
                    </button>
                </div>
                <div class="min-h-[20px]">
                    <span x-show="errors.password" class="text-[10px] text-red-600 font-semibold" x-text="errors.password" x-cloak></span>
                    @error('password')<span class="text-[10px] text-red-600 font-semibold">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary/20 border-slate-300">
                    Recordarme
                </label>
                <a href="{{ route('password.request') }}" class="text-primary font-semibold hover:underline text-xs">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white py-2.5 rounded-xl font-bold transition-all shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">login</span>
                Iniciar Sesión
            </button>

            <div class="pt-3 border-t border-slate-100 text-center space-y-1.5">
                <p class="text-sm text-slate-600">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Regístrate</a>
                </p>
                <p class="text-xs text-slate-500">
                    ¿Eres paciente?
                    <a href="{{ route('patient.login') }}" class="text-primary font-bold hover:underline">Portal del Paciente</a>
                </p>
            </div>
        </form>

    </div>

</body>
</html>