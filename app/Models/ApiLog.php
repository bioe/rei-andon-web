<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ApiLog extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'header',
        'payload',
    ];
}
