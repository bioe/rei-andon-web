<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WatchLoginLog extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'watch_id',
        'user_id',
        'mode',
        'success',
        'cancel',
        'login_at',
        'logout_at',
    ];

    public function watch(): BelongsTo
    {
        return $this->belongsTo(Watch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfPending($query)
    {
        return $query->whereNull('success')->whereNull('cancel');
    }

    public function scopeToLogout($query)
    {
        return $query->where('success', true)->whereNull('cancel')->whereNotNull('login_at')->whereNull('logout_at');
    }

    public function scopePollLogout($query)
    {
        return $query->where('success', true)->whereNull('cancel')->whereNotNull('login_at')->whereNull('logout_at')->where('poll_logout', true);
    }

    //Login success need to update to the watch row as well
    public function updateWatch()
    {
        $this->watch->login_user_id = $this->user_id;
        $this->watch->login_at = Carbon::now();
        $this->watch->save();
    }
}
