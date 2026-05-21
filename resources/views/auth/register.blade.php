<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Registro de Médico - WebCitaSys</title>
    
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

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        
        <!-- Header Section -->
        <div class="bg-inverse-surface p-6 text-center text-white relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-transparent opacity-50"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-primary-container text-white rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg border border-primary/20">
                    <span class="material-symbols-outlined text-3xl">local_hospital</span>
                </div>
                <h1 class="text-xl font-bold tracking-tight font-display" style="font-family: 'Hanken Grotesk', sans-serif;">WebCitaSys</h1>
                <p class="text-slate-300 text-xs">Registro del Personal Médico</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('register') }}" method="POST" novalidate
              x-data="{
                  errors: { first_name: '', last_name: '', specialty: '', email: '', password: '' },
                  showPass: false,
                  showConfirm: false,
                  validateForm(e) {
                      let hasError = false;
                      this.errors = { first_name: '', last_name: '', specialty: '', email: '', password: '' };
                      
                      const first_name = document.getElementById('first_name').value.trim();
                      if (!first_name) {
                          this.errors.first_name = 'El nombre es obligatorio.';
                          hasError = true;
                      }
                      
                      const last_name = document.getElementById('last_name').value.trim();
                      if (!last_name) {
                          this.errors.last_name = 'El apellido es obligatorio.';
                          hasError = true;
                      }
                      
                      const specialty = document.getElementById('specialty').value;
                      if (!specialty) {
                          this.errors.specialty = 'La especialidad médica es obligatoria.';
                          hasError = true;
                      }
                      
                      const email = document.getElementById('email').value.trim();
                      if (!email) {
                          this.errors.email = 'El correo electrónico es obligatorio.';
                          hasError = true;
                      } else if (!email.includes('@')) {
                          this.errors.email = 'El correo electrónico debe ser una dirección válida.';
                          hasError = true;
                      }
                      
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
              class="p-8 space-y-4">
            @csrf
            
            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Hanken Grotesk', sans-serif;">Crear Cuenta de Médico</h2>
                <p class="text-slate-500 text-xs mt-1">Regístrate para acceder a todos los servicios médicos.</p>
            </div>

            <!-- Grid: Nombre y Apellido -->
            <div class="grid grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="space-y-1">
                    <label for="first_name" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Nombre Completo</label>
                    <input type="text" name="first_name" id="first_name" required value="{{ old('first_name') }}"
                           class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                           placeholder="Carlos">
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.first_name" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.first_name" x-cloak></span>
                        <template x-if="!errors.first_name">
                            <div>
                                @error('first_name')
                                    <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                                @enderror
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="space-y-1">
                    <label for="last_name" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Apellido Completo</label>
                    <input type="text" name="last_name" id="last_name" required value="{{ old('last_name') }}"
                           class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                           placeholder="Mendoza">
                    <div class="min-h-[22px] mt-1">
                        <span x-show="errors.last_name" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.last_name" x-cloak></span>
                        <template x-if="!errors.last_name">
                            <div>
                                @error('last_name')
                                    <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                                @enderror
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Specialty -->
            <div class="space-y-1">
                <label for="specialty" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Especialidad Médica</label>
                <select name="specialty" id="specialty" required
                        class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base text-slate-800 transition-colors">
                    <option value="" class="text-slate-400">Selecciona especialidad...</option>
                    <option value="Medicina General" {{ old('specialty') == 'Medicina General' ? 'selected' : '' }}>Medicina General</option>
                    <option value="Cardiología" {{ old('specialty') == 'Cardiología' ? 'selected' : '' }}>Cardiología</option>
                    <option value="Pediatría" {{ old('specialty') == 'Pediatría' ? 'selected' : '' }}>Pediatría</option>
                    <option value="Ginecología" {{ old('specialty') == 'Ginecología' ? 'selected' : '' }}>Ginecología</option>
                    <option value="Dermatología" {{ old('specialty') == 'Dermatología' ? 'selected' : '' }}>Dermatología</option>
                    <option value="Oftalmología" {{ old('specialty') == 'Oftalmología' ? 'selected' : '' }}>Oftalmología</option>
                </select>
                <div class="min-h-[22px] mt-1">
                    <span x-show="errors.specialty" class="text-xs text-slate-900 font-semibold block leading-tight" x-text="errors.specialty" x-cloak></span>
                    <template x-if="!errors.specialty">
                        <div>
                            @error('specialty')
                                <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                            @enderror
                        </div>
                    </template>
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Correo Electrónico</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                       class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                       placeholder="carlos@webcitasys.com">
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

            <!-- Passwords Row with Alpine toggles -->
            <div class="grid grid-cols-2 gap-6">
                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Contraseña</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" id="password" required 
                               class="w-full bg-transparent border-0 border-b border-slate-200 pl-0 pr-8 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                               placeholder="Mín. 6 caracteres">
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

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Confirmar</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required 
                               class="w-full bg-transparent border-0 border-b border-slate-200 pl-0 pr-8 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                               placeholder="Repite contraseña">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-0 top-2.5 text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-xl" x-text="showConfirm ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                    <div class="min-h-[22px] mt-1">
                        <!-- Space reserved for password match warning or confirm placeholder -->
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-bold transition-all shadow-md active:scale-[0.99] flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined text-lg">how_to_reg</span>
                Registrar Cuenta
            </button>

            <!-- Login Link -->
            <p class="text-center text-sm text-slate-600 pt-2">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Inicia sesión aquí</a>
            </p>
        </form>

    </div>

</body>
</html>
