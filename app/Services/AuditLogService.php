<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    public static function log($action, $model, $oldValues = null, $newValues = null)
    {
        // Don't log if user is not authenticated
        if (!Auth::check()) {
            return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id ?? null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logCreate($model, $values = null)
    {
        self::log('create', $model, null, $values ?? $model->toArray());
    }

    public static function logUpdate($model, $oldValues, $newValues = null)
    {
        self::log('update', $model, $oldValues, $newValues ?? $model->toArray());
    }

    public static function logDelete($model, $values = null)
    {
        self::log('delete', $model, $values ?? $model->toArray(), null);
    }
}