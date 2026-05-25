<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>WebCitaSys - Registro de Paciente</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#005ea1", "primary-container": "#2178c3",
                        secondary: "#006a63", "secondary-container": "#79f7ea",
                        error: "#ba1a1a", "error-container": "#ffdad6",
                        surface: "#f9f9ff", "on-surface": "#161c27",
                        "surface-variant": "#dde2f3", "on-surface-variant": "#414751",
                    },
                    fontFamily: { display: ["Hanken Grotesk"], body: ["Manrope"] },
                }
            }
        }
    </script>
    <style>
        body { background: linear-gradient(135deg, #f9f9ff 0%, #dde2f3 100%); min-height: 100vh; font-family: 'Manrope', sans-serif; }
        .glass-card { background: rgba(255,255,255,0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.06); }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-4">
                <span class="material-symbols-outlined text-3xl">local_hospital</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-primary">WebCitaSys</h1>
            <p class="text-sm text-on-surface-variant mt-1">Crear Cuenta de Paciente</p>
        </div>

        <div class="glass-card rounded-2xl p-8">
            <h2 class="text-xl font-bold text-on-surface mb-6">Registro</h2>

            @if($errors->any())
            <div class="mb-4 p-3 bg-error-container text-error rounded-xl text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('patient.register') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Nombre(s) *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="Juan">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Apellido(s) *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="Pérez">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Tipo Doc *</label>
                        <select name="document_type" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm">
                            <option value="CC">CC</option>
                            <option value="TI">TI</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Nº Documento *</label>
                        <input type="text" name="document_number" value="{{ old('document_number') }}" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="12345678">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Correo Electrónico *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="tu@correo.com">
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Teléfono / Celular</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="3112223344">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Contraseña *</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="Mín. 6 caracteres">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Confirmar *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" placeholder="Repetir contraseña">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-all shadow-md">
                    Crear Cuenta
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-on-surface-variant">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('patient.login') }}" class="text-primary font-bold hover:underline">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
