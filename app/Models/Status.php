<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'state',
        'button_1',
        'button_2',
        'active',
        'sequence',
        'last_edit_user_id'
    ];

    //Default attributes
    protected $attributes = [
        'active' => true,
        'button_1' => 'WILL ATTEND',
        'button_2' => 'UNABLE TO ATTEND'
    ];

    public function active(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value ? true : false
        );
    }

    public function code(): Attribute
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
            ['field' => 'code', 'title' => 'Code', 'sortable' => true],
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'state', 'title' => 'State', 'sortable' => true],
        ];

        return array_merge($headers, [
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
