<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FillableModel extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id', 'created_at'];
}
