<?php

namespace App\Services;

use App\Models\User;

class PermissionService
{
    public function userHasPermission(User $user, string $permission): bool
    {
        if (!$user->role) {
            return false;
        }

        return $user->role->hasPermission($permission);
    }

    public function userHasAnyPermission(User $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->userHasPermission($user, $permission)) {
                return true;
            }
        }
        return false;
    }

    public function userHasAllPermissions(User $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->userHasPermission($user, $permission)) {
                return false;
            }
        }
        return true;
    }

    public function getAllowedModules(User $user): array
    {
        $modules = [];

        if ($this->userHasPermission($user, '*')) {
            return array_keys(config('permissions.modules', []));
        }

        foreach (config('permissions.modules', []) as $module => $config) {
            foreach ($config['actions'] as $action) {
                if ($this->userHasPermission($user, $module . '.' . $action)) {
                    $modules[] = $module;
                    break;
                }
            }
        }

        return $modules;
    }

    public function getRolePermissions(string $roleSlug): array
    {
        return config("permissions.roles.{$roleSlug}.permissions", []);
    }

    public function canAccessModule(User $user, string $module): bool
    {
        if ($this->userHasPermission($user, '*')) {
            return true;
        }

        $moduleConfig = config("permissions.modules.{$module}");

        if (!$moduleConfig) {
            return false;
        }

        foreach ($moduleConfig['actions'] as $action) {
            $perm = $module . '.' . $action;
            if ($this->userHasPermission($user, $perm)) {
                return true;
            }
        }

        return false;
    }
}
