<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponseRecord extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'employee_code',
        'response_option',
        'attending',
        'response_duration_second',
        'status_record_id',
    ];

    public function status_record(): BelongsTo
    {
        return $this->belongsTo(StatusRecord::class);
    }
}
