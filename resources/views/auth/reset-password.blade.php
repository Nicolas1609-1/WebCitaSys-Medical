<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Establecer Nueva Contraseña - WebCitaSys</title>
    
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
                    <span class="material-symbols-outlined text-4xl">vpn_key</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight font-display" style="font-family: 'Hanken Grotesk', sans-serif;">WebCitaSys</h1>
                <p class="text-slate-300 text-sm mt-1">Nueva Contraseña</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('password.update') }}" method="POST" novalidate
              x-data="{
                  errors: { password: '' },
                  validateForm(e) {
                      let hasError = false;
                      this.errors = { password: '' };
                      
                      const password = document.getElementById('password').value;
                      if (!password) {
                          this.errors.password = 'La contraseña es obligatoria.';
                          hasError = true;
                      } else if (password.length < 6) {
                          this.errors.password = 'La contraseña debe tener al menos 6 caracteres.';
                          hasError = true;
                      }
                      
                      const confirm = document.getElementById('password_confirmation').value;
                      if (password && password !== confirm) {
                          this.errors.password = 'Las contraseñas no coinciden.';
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
            
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Hanken Grotesk', sans-serif;">Establece tu nueva contraseña</h2>
                <p class="text-slate-500 text-xs mt-1">Introduce una contraseña de al menos 6 caracteres para tu cuenta: <span class="font-semibold text-primary">{{ $email }}</span></p>
            </div>

            <!-- Passwords with Alpine toggles -->
            <div class="space-y-4" x-data="{ showPass: false, showConfirm: false }">
                <!-- Password Field -->
                <div class="space-y-1">
                    <label for="password" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Nueva Contraseña</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" id="password" required 
                               class="w-full bg-transparent border-0 border-b border-slate-200 pl-0 pr-8 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                               placeholder="••••••••">
                        <button type="button" @click="showPass = !showPass" class="absolute right-0 top-2.5 text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-xl" x-text="showPass ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.password" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.password" x-cloak></span>
                        <template x-if="!errors.password">
                            <div>
                                @error('password')
                                    <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                                @enderror
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Confirmar Nueva Contraseña</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required 
                               class="w-full bg-transparent border-0 border-b border-slate-200 pl-0 pr-8 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                               placeholder="••••••••">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-0 top-2.5 text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-xl" x-text="showConfirm ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                    <div class="min-h-[22px] mt-1">
                        <!-- Space reserved for password match warning -->
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-bold transition-all shadow-md active:scale-[0.99] flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                Restablecer Contraseña
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
