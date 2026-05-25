<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Services\AuditService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $users = User::with('role', 'doctor')
            ->when($search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($roleFilter, function ($q, $roleFilter) {
                $q->whereHas('role', fn($r) => $r->where('slug', $roleFilter));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'search', 'roleFilter'));
    }

    public function create()
    {
        $roles = Role::where('slug', '!=', 'patient')->orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'required_if:is_doctor,on|string|max:255',
            'last_name' => 'required_if:is_doctor,on|string|max:255',
            'specialty' => 'required_if:is_doctor,on|string|max:255',
            'license_number' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $role = Role::find($request->role_id);

        if ($role && $role->slug === 'doctor' && $request->is_doctor) {
            Doctor::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'specialty' => $request->specialty,
                'license_number' => $request->license_number,
                'email' => $request->email,
            ]);
        }

        $this->auditService->logCreated('users', $user, "Usuario {$user->name} creado por " . Auth::user()->name);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $user = User::with('role', 'doctor')->findOrFail($id);
        $roles = Role::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $oldData = $user->toArray();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $this->auditService->logUpdated('users', $user, $oldData, "Usuario {$user->name} actualizado por " . Auth::user()->name);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propio usuario.']);
        }

        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        $this->auditService->logDeleted('users', null, "Usuario {$userName} eliminado por " . Auth::user()->name);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
