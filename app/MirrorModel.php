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
