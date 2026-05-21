<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Recuperar Contraseña - WebCitaSys</title>
    
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
                    <span class="material-symbols-outlined text-4xl">lock_reset</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight font-display" style="font-family: 'Hanken Grotesk', sans-serif;">WebCitaSys</h1>
                <p class="text-slate-300 text-sm mt-1">Recuperación de Contraseña</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('password.email') }}" method="POST" novalidate
              x-data="{
                  errors: { email: '' },
                  validateForm(e) {
                      let hasError = false;
                      this.errors = { email: '' };
                      
                      const email = document.getElementById('email').value.trim();
                      if (!email) {
                          this.errors.email = 'El correo electrónico es obligatorio.';
                          hasError = true;
                      } else if (!email.includes('@')) {
                          this.errors.email = 'El correo electrónico debe ser una dirección válida.';
                          hasError = true;
                      }
                      
                      if (hasError) {
                          e.preventDefault();
                      }
                  }
              }"
              @submit="validateForm($event)"
              class="p-8 space-y-5">
            @csrf
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Hanken Grotesk', sans-serif;">¿Olvidaste tu contraseña?</h2>
                <p class="text-slate-500 text-xs mt-1">Ingresa tu correo electrónico registrado y te permitiremos restablecer tu acceso.</p>
            </div>

            <!-- Email Field -->
            <div class="space-y-1">
                <label for="email" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Correo Electrónico</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" 
                       class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                       placeholder="ejemplo@webcitasys.com">
                <div class="min-h-[22px] mt-1">
                    <span x-show="errors.email" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.email" x-cloak></span>
                    <template x-if="!errors.email">
                        <div>
                            @error('email')
                                <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                            @enderror
                        </div>
                    </template>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-bold transition-all shadow-md active:scale-[0.99] flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                Verificar Correo
            </button>

            <!-- Back to Login Link -->
            <p class="text-center text-sm text-slate-600 pt-2">
                <a href="{{ route('login') }}" class="text-primary font-bold hover:underline flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Volver a Iniciar Sesión
                </a>
            </p>
        </form>

    </div>

</body>
</html>
