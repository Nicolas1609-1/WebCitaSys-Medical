<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>WebCitaSys - Portal del Paciente</title>
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
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-4">
                <span class="material-symbols-outlined text-3xl">local_hospital</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-primary">WebCitaSys</h1>
            <p class="text-sm text-on-surface-variant mt-1">Portal del Paciente</p>
        </div>

        <div class="glass-card rounded-2xl p-8">
            <h2 class="text-xl font-bold text-on-surface mb-6">Iniciar Sesión</h2>

            @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-50 text-emerald-800 rounded-xl text-sm font-semibold">{{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div class="mb-4 p-3 bg-error-container text-error rounded-xl text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('patient.login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm"
                           placeholder="tu@correo.com">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-primary/20 focus:border-primary text-sm"
                           placeholder="••••••••">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-on-surface-variant">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary">
                        Recordarme
                    </label>
                </div>
                <button type="submit" class="w-full py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-all shadow-md">
                    Ingresar
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                <p class="text-sm text-on-surface-variant">
                    ¿No tienes cuenta?
                    <a href="{{ route('patient.register') }}" class="text-primary font-bold hover:underline">Regístrate aquí</a>
                </p>
                <p class="text-xs text-on-surface-variant">
                    <a href="{{ route('login') }}" class="hover:underline">¿Eres parte del personal? Ingresa aquí</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
