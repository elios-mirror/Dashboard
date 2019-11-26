<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\MirrorModule
 *
 * @property-read \App\ModuleVersion $module
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MirrorModule query()
 * @mixin \Eloquent
 */
class MirrorModule extends Pivot
{
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


  protected $fillable = [
      'form',
      'settings'
  ];


  public function module()
  {
    return $this->hasOne(ModuleVersion::class, 'id', 'module_id');
  }
}
