<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desiccator extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'temperature',
        'humidity',
        'alarm',
        'gas',
        'switch1',
        'switch2',
        'switch3',
        'switch4',
        'cylinder_top',
        'cylinder_bottom',
        'safety_curtain'
    ];

    //Default attributes
    protected $attributes = [];
}
