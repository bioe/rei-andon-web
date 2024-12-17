<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabinet extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'box_id',
        'box_no',
        'status',
        'last_operate_user_id',
        'last_occur_at'
    ];

    public function last_operate_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_operate_user_id');
    }
}
