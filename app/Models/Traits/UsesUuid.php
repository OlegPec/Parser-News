<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UsesUuid
{
//    public $incrementing = false;
//    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
//            $tip->id = (string) Str::uuid();
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
