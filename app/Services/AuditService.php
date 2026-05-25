<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public function log(
        string $action,
        string $module,
        ?string $description = null,
        $oldValues = null,
        $newValues = null
    ): AuditLog {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function logCreated(string $module, $model, ?string $description = null): AuditLog
    {
        return $this->log('created', $module, $description ?? "Creación en {$module}", null, $model?->toArray());
    }

    public function logUpdated(string $module, $model, $oldValues, ?string $description = null): AuditLog
    {
        return $this->log('updated', $module, $description ?? "Actualización en {$module}", $oldValues, $model?->toArray());
    }

    public function logDeleted(string $module, $model, ?string $description = null): AuditLog
    {
        return $this->log('deleted', $module, $description ?? "Eliminación en {$module}", $model?->toArray(), null);
    }

    public function logLogin(): AuditLog
    {
        return $this->log('login', 'auth', 'Inicio de sesión');
    }

    public function logLogout(): AuditLog
    {
        return $this->log('logout', 'auth', 'Cierre de sesión');
    }
}
