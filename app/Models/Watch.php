<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Watch extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'model',
        'ip_address',
        'active',
        'last_edit_user_id'
    ];

    //Default attributes
    protected $attributes = [
        'active' => true,
    ];

    public function active(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value ? true : false
        );
    }

    public function isConnected(): Attribute
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

    public function login_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'login_user_id');
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [
            ['field' => 'code', 'title' => 'Code', 'sortable' => true],
            ['field' => 'ip_address', 'title' => 'IP Address', 'sortable' => true],
            ['field' => '', 'title' => 'Login Operator', 'sortable' => false],

        ];

        return array_merge($headers, [
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
