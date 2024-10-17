<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'employee_name', //From REI the username & code is combine USER#0000, separate out
        'remark',
        'segment_code',
        'machine_code',
        'machine_type',
        'attended_at',
        'attend_duration_second', //When operator is infront of the machine and press "LOCAL"
        'resolved_at',
        'resolve_duration_second', //When machine turn back to GREEN
        'completed_at', //When operator send job complete
        'complete_duration_second',
        'ask_help_at',
        'active',
        'origin',
        'status_record_help_id' //To refer back the original status record when sending a help
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

    public function segmentCode(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value)
        );
    }

    public function machineCode(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value)
        );
    }

    public function machineType(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value)
        );
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ResponseRecord::class)->orderBy('created_at', 'desc');
    }

    public function attending(): HasOne
    {
        return $this->hasOne(ResponseRecord::class)->where('attending', true)->orderBy('created_at', 'desc');
    }

    public function segment(): HasOne
    {
        return $this->hasOne(Segment::class, 'code', 'segment_code');
    }

    public function scopeOfMachine($query, array $data)
    {
        return $query->where("segment_code", strtoupper($data['segment_code']))
            ->where('machine_code', strtoupper($data['machine_code']))
            ->where('machine_type', strtoupper($data['machine_type']));
    }

    public function scopeOfInCategory($query, array $data)
    {
        return $query->whereIn("segment_code", $data['segment_codes'])
            ->when(count($data['machine_types']) > 0, function ($q) use ($data) {
                $q->whereIn('machine_type', $data['machine_types']);
            });
    }

    /*
    * Only those Relavent Group
    */
    public function scopeOfUserGroup($query, array $groups)
    {
        return $query->where(function ($query) use ($groups) {
            foreach ($groups as $group) {
                $query->orWhere(function ($query) use ($group) {
                    $query->where('segment_code', $group['segment_code']);
                    if (count($group['machine_types']) > 0) {
                        $query->whereIn('machine_type', $group['machine_types']);
                    }
                });
            }
        });
    }

    public function scopeOfIsNew($query)
    {
        return $query->whereDoesntHave('responses', function ($q) {
            $q->where('attending', 1);
        });
    }

    public function scopeOfSelfNoResponse($query, $employee_code)
    {
        return $query->whereDoesntHave('responses', function ($q) use ($employee_code) {
            $q->where('employee_code', $employee_code);
        });
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [
            ['field' => 'machine_code', 'title' => 'Machine', 'sortable' => true],
            ['field' => 'segment_code', 'title' => 'Zone', 'sortable' => true],
            ['field' => 'employee_code', 'title' => 'Request By', 'sortable' => true],
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
            ['field' => '', 'title' => 'Status', 'sortable' => false],
            ['field' => '', 'title' => 'Response', 'sortable' => false],
            ['field' => '', 'title' => 'Attend', 'sortable' => false],
            ['field' => '', 'title' => 'Resolve', 'sortable' => false],
            ['field' => '', 'title' => 'Complete', 'sortable' => false],

        ];

        return $headers;
    }
}
