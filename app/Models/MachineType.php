<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineType extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
    ];

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [
            ['field' => 'code', 'title' => 'Code', 'sortable' => true],
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
        ];

        return array_merge($headers, [
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
