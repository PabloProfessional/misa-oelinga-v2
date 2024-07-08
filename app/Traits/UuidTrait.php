<?php

namespace App\Traits;

use Illuminate\Support\Str;


trait UuidTrait
{
    protected static function bootUuidTrait(): void
    {
//        static::creating(function ($model) {
//            $model->{$model->getKeyName()} = Str::uuid();
//        });

        static::creating(function ($model) {
            $model->uuid = Str::uuid(); // Update the 'uuid' field with a UUID value
        });
    }
}
