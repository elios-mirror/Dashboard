<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

trait Uuids
{

  /**
   * Boot function from laravel.
   */
  protected static function bootUuids()
  {
    static::creating(function ($model) {
      $model->{$model->getKeyName()} = Uuid::generate()->string;
    });
  }


  /**
   * Create a new pivot model from raw values returned from a query.
   * @param \Illuminate\Database\Eloquent\Model $parent
   * @param array $attributes
   * @param string $table
   * @param bool $exists
   * @return static
   * @throws \Exception
   */
  public static function fromRawAttributes(Model $parent, $attributes, $table, $exists = false)
  {
    if (!$exists and !array_key_exists('id', $attributes)) {
      $attributes['id'] = Uuid::generate(4)->string;
    }
    return parent::fromRawAttributes($parent, $attributes, $table, $exists);
  }

}