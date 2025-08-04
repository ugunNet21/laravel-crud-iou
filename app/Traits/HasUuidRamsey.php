<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuidRamsey
{
    protected static function bootHasUuidRamsey()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Uuid::uuid7()->toString();
            }
        });
    }
}
