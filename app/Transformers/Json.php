<?php
/**
 * Created by PhpStorm.
 * User: hubert_i
 * Date: 05/06/2018
 * Time: 15:10
 */

namespace App\Transformers;


class Json
{
    public static function response($data = null, $message = null)
    {
        return [
            'data'    => $data,
            'message' => $message,
        ];
    }
}