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
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ModuleVersion[] $versions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereDescription($value)
 * @property string $category
 * @property string $logo_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereLogoUrl($value)
 */
class Module extends Model
{
    use Uuids;


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
        'repository',
        'title',
        'name'
    ];

    public function lastVersion()
    {
        return $this->hasMany('App\ModuleVersion', 'module_id')->latest()->first();
    }

    public function versions()
    {
        return $this->hasMany('App\ModuleVersion', 'module_id')->latest();
    }
}
