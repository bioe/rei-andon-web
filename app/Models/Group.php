<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'description',
        'active',
        'segment_code',
        'machine_list',
        'status_list',
        'last_edit_user_id'
    ];

    protected $casts = [
        'machine_list' => 'array',
        'status_list' => 'array',
    ];

    protected $attributes = [
        'active' => true,
    ];

    protected $appends = [
        'machines_label',
    ];

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value ? true : false
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

    protected function segmentCode(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value)
        );
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value)
        );
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [
            ['field' => 'code', 'title' => 'Code', 'sortable' => true], //Rename to Code, because need unique and use for import&export
            ['field' => 'description', 'title' => 'Description', 'sortable' => true],
            ['field' => 'segment_code', 'title' => 'Segment / Zone', 'sortable' => false],
            ['field' => 'machine_list', 'title' => 'Machines', 'sortable' => false],
            ['field' => 'status_list', 'title' => 'Statuses', 'sortable' => false],
        ];

        return array_merge($headers, [
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
