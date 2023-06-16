<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuids
{
    /**
     * Boot function from Laravel.
     */
    protected static function bootUuids()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public static function whereUuid($uuid)
    {
        return self::where('uuid', $uuid);
    }
}
