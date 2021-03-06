<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @property string $changelog
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModuleVersion whereChangelog($value)
 */
class ModuleVersion extends Model
{
  use Uuids;

  protected $primaryKey = "id";

  protected $casts = [
      'id' => 'string'
  ];

  protected $fillable = [
      'settings',
      'form'
  ];

  public function module()
  {
    return $this->hasOne(Module::class, 'id', 'module_id');
  }
}
