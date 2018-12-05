<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * App\Module
 *
 * @property string $id
 * @property string $title
 * @property string $name
 * @property string $repository
 * @property string $publisher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ModuleVersion[] $lastVersion
 */
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
        return $this->hasMany('App\ModuleVersion', 'module_id')->latest();
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
