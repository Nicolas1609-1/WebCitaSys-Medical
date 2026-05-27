<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('patient.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->role?->slug !== 'patient') {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors([
                    'email' => 'Esta cuenta no es de paciente. Usa el inicio de sesión del personal.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('patient.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'document_type' => 'required|string|max:10',
            'document_number' => 'required|string|max:50|unique:patients',
            'phone' => 'nullable|string|max:50',
        ]);

        $patientRole = Role::where('slug', 'patient')->first();

        if (!$patientRole) {
            return back()->withErrors(['error' => 'Error de configuración del sistema. Contacta al administrador.']);
        }

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $patientRole->id,
        ]);

        Patient::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Cuenta creada exitosamente. Bienvenido a WebCitaSys.');
    }
}
