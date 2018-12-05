<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mirror
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mirror extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'model'
    ];

    public function getModel()
    {
        return $this->hasOne('App\MirrorModel', 'model');
    }
}
