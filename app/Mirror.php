<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

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
 * @property string $model
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Module[] $modules
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mirror whereModel($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
class Mirror extends Authenticatable
{
    use Uuids, Notifiable, HasMultiAuthApiTokens;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'model'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'ip',
    ];

    public function model()
    {
        return $this->hasOne('App\MirrorModel', 'model');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_mirrors', 'mirror_id', 'user_id')
            ->using(UserMirror::class)
            ->as('link')
            ->withPivot(['id']);
    }
}
