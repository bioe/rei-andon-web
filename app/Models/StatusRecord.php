<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class StatusRecord extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status_id',
        'status_date',
        'create_employee_code',
        'response_employee_code',
        'response_option',
        'response_at',
        'remark',
        'machine_id'
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
}
