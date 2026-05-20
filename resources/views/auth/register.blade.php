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
        <form action="{{ route('register') }}" method="POST" class="p-8 space-y-4">
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
                        @error('first_name')
                            <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                        @else
                            @if(old('first_name') === null && $errors->any())
                                <span class="text-xs text-slate-900 font-semibold block leading-tight">El nombre es obligatorio.</span>
                            @endif
                        @enderror
                    </div>
                </div>

                <!-- Last Name -->
                <div class="space-y-1">
                    <label for="last_name" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Apellido Completo</label>
                    <input type="text" name="last_name" id="last_name" required value="{{ old('last_name') }}"
                           class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                           placeholder="Mendoza">
                    <div class="min-h-[22px] mt-1">
                        @error('last_name')
                            <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                        @else
                            @if(old('last_name') === null && $errors->any())
                                <span class="text-xs text-slate-900 font-semibold block leading-tight">El apellido es obligatorio.</span>
                            @endif
                        @enderror
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
                    @error('specialty')
                        <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-800">Correo Electrónico</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                       class="w-full bg-transparent border-0 border-b border-slate-200 px-0 py-2 focus:ring-0 focus:border-primary text-base placeholder-slate-300 transition-colors" 
                       placeholder="carlos@webcitasys.com">
                <div class="min-h-[22px] mt-1">
                    @error('email')
                        <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                    @else
                        @if(old('email') === null && $errors->any())
                            <span class="text-xs text-slate-900 font-semibold block leading-tight">El correo electrónico es obligatorio.</span>
                        @endif
                    @enderror
                </div>
            </div>

            <!-- Passwords Row with Alpine toggles -->
            <div class="grid grid-cols-2 gap-6" x-data="{ showPass: false, showConfirm: false }">
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
                        @error('password')
                            <span class="text-xs text-slate-900 font-semibold block leading-tight">{{ $message }}</span>
                        @else
                            @if($errors->any())
                                <span class="text-xs text-slate-900 font-semibold block leading-tight">La contraseña es obligatoria.</span>
                            @endif
                        @enderror
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
