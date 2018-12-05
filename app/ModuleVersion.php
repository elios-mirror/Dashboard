<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * App\ModuleVersion
 *
 * @property string $id
 * @property string $commit
 * @property string $version
 * @property string $module_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Module $module
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereCommit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereVersion($value)
 * @mixin \Eloquent
 */
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
