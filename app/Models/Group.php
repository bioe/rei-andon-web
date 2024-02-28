<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'active',
        'machine_list',
        'last_edit_user_id'
    ];

    protected $casts = [
        'machine_list' => 'array',
    ];

    protected $attributes = [
        'active' => true,
    ];

    protected $appends = [
        'machines_label'
    ];

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? true : false
        );
    }

    protected function machinesLabel(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $ml = isset($attributes['machine_list']) ? $attributes['machine_list'] : "";
                if (empty($ml)) {
                    return "";
                }
                // Remove the square brackets
                return str_replace('"', '', trim($ml, '[]'));
            }
        );
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'description', 'title' => 'Description', 'sortable' => true],
            ['field' => 'machine_list', 'title' => 'Machines', 'sortable' => false],
        ];

        return array_merge($headers, [
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
