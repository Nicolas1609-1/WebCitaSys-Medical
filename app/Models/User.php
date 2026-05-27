<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Services\PermissionService;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission(string $permission): bool
    {
        return app(PermissionService::class)->userHasPermission($this, $permission);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return app(PermissionService::class)->userHasAnyPermission($this, $permissions);
    }

    public function canAccessModule(string $module): bool
    {
        return app(PermissionService::class)->canAccessModule($this, $module);
    }

    public function isAdmin(): bool
    {
        return $this->role?->slug === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role?->slug === 'doctor';
    }

    public function isReceptionist(): bool
    {
        return $this->role?->slug === 'receptionist';
    }

    public function isFinancial(): bool
    {
        return $this->role?->slug === 'financial';
    }

    public function isSupport(): bool
    {
        return $this->role?->slug === 'support';
    }

    public function isPatient(): bool
    {
        return $this->role?->slug === 'patient';
    }

    public function getRoleDisplayName(): string
    {
        return $this->role?->name ?? 'Sin rol';
    }

    public function getRoleBadgeAttribute(): string
    {
        return match($this->role?->slug) {
            'admin' => 'bg-purple-100 text-purple-800',
            'doctor' => 'bg-blue-100 text-blue-800',
            'receptionist' => 'bg-emerald-100 text-emerald-800',
            'financial' => 'bg-amber-100 text-amber-800',
            'support' => 'bg-slate-100 text-slate-800',
            'patient' => 'bg-cyan-100 text-cyan-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
