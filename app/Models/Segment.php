<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'active',
    ];

    protected $attributes = [
        'active' => true,
    ];

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? true : false
        );
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value)
        );
    }

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
