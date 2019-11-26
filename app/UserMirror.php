<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\UserMirror
 *
 * @property string $id
 * @property string $mirror_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Mirror[] $mirror
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror whereMirrorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMirror whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ModuleVersion[] $modules
 */
class UserMirror extends Pivot
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     * @var string
     */
    public $keyType = 'string';


    public function modules()
    {
        return $this->belongsToMany(
            ModuleVersion::class,
            'mirror_modules',
            'link_id',
            'module_id')
            ->using(MirrorModule::class)
            ->as('link')
            ->withPivot(['id', 'settings', 'form']);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_mirrors', 'mirror_id', 'user_id');
    }


    public function mirror()
    {
        return $this->belongsToMany(Mirror::class, 'user_mirrors', 'user_id', 'mirror_id');
    }

}
