<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Module extends Model
{
    protected $primaryKey = "id";

    protected $casts = [
        'id' => 'string'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'repository',
        'title',
        'name'
    ];

    public function lastVersion()
    {
        return $this->hasMany('App\ModuleVersion', 'module_id')->last();
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
