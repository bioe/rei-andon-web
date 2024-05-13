<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'active',
        'machine_type_id',
        'segment_id'
    ];

    //Default attributes
    protected $attributes = [
        'active' => true,
    ];

    public function active(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? true : false
        );
    }

    public function machine_type()
    {
        return $this->belongsTo(MachineType::class, 'machine_type_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }

    public function last_status_record()
    {
        return $this->hasOne(StatusRecord::class, 'machine_code', 'code')->orderBy('created_at', 'desc');
    }

    public function code(): Attribute
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
            ['field' => '', 'title' => 'Type', 'sortable' => false],
            ['field' => '', 'title' => 'Zone', 'sortable' => false],
        ];

        return array_merge($headers, [
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
