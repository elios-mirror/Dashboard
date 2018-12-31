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


    public function modules($userId = null, $installId = null)
    {
        if ($userId && $installId)
            return $this->belongsToMany('App\ModuleVersion', 'mirror_modules', 'mirror_id', 'module_id')->withPivot(['user_id', 'install_id'])->where('user_id', $userId)->where('install_id', $installId);
        else if ($userId)
            return $this->belongsToMany('App\ModuleVersion', 'mirror_modules', 'mirror_id', 'module_id')->withPivot(['user_id', 'install_id'])->where('user_id', $userId);
        return $this->belongsToMany('App\ModuleVersion', 'mirror_modules', 'mirror_id', 'module_id')->withPivot(['user_id', 'install_id']);
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_mirrors', 'mirror_id', 'user_id');
    }
}
