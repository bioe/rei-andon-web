<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Robot extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pick_oven',
        'put_oven',
        'pick_desiccator',
        'put_desiccator',
        'pick_count',
        'stop'
    ];

    //Default attributes
    protected $attributes = [];
}
