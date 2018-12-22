<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MirrorModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModel query()
 * @mixin \Eloquent
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModel whereUpdatedAt($value)
 */
class MirrorModel extends Model
{

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id'
    ];

}
