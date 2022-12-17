<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Config extends FillableModel
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'json',
    ];


    public static function getItem($key, $default = null)
    {
        return self::where('key', $key)->first()->value ?? $default;
    }
}
