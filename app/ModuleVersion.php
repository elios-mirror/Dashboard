<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ModuleVersion extends Model
{
    protected $primaryKey = "id";

    protected $casts = [
        'id' => 'string'
    ];

    public function module()
    {
        return $this->hasOne('App\Module', 'module_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
