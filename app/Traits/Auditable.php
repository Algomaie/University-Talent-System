<?php

namespace App\Traits;

use App\Services\AuditLogService;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            AuditLogService::logCreate($model);
        });

        static::updated(function ($model) {
            // Get the original values before the update
            $oldValues = [];
            $newValues = [];
            
            foreach ($model->getDirty() as $attribute => $value) {
                $oldValues[$attribute] = $model->getOriginal($attribute);
                $newValues[$attribute] = $value;
            }
            
            AuditLogService::logUpdate($model, $oldValues, $newValues);
        });

        static::deleted(function ($model) {
            AuditLogService::logDelete($model);
        });
    }
}