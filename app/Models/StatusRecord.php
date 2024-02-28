<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'employee_id',
        'employee_code',
        'remark',
        'segment_code',
        'machine_code',
        'attended_at',
        'attend_duration_second', //When operator is infront of the machine and press "LOCAL"
        'resolved_at',
        'resolve_duration_second', //When machine turn back to GREEN
        'active',
        'origin'
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

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ResponseRecord::class);
    }

    public function scopeOfMachine($query, array $data)
    {
        return $query->where("segment_code", strtoupper($data['segment_code']))
            ->where('machine_code', strtoupper($data['machine_code']));
    }
}
