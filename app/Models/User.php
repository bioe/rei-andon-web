<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\AuthModal as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'active',
        'user_type',
        'shift',
        'badge_no',
        'watch_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'menus' => 'array',
    ];

    //Default attributes
    protected $attributes = [
        'active' => true,
        'user_type' => OPERATOR,
        'shift' => null,
    ];

    protected $appends = [
        'menu_flags',
        'employee_code',
        'logout_time'
    ];

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value ? true : false
        );
    }

    protected function username(): Attribute
    {
        if (env(LOGIN_USERNAME, false)) {
            return Attribute::make(
                set: fn(string $value) => $value != null ? strtolower($value) : null,
            );
        }
        return Attribute::make();
    }

    protected function employeeCode(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => isset($attributes['username']) ? $attributes['username'] : ''
        );
    }

    protected function logoutTime(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => isset($attributes['shift']) && $attributes['shift'] == NIGHT ? "07:00" : "19:00"
        );
    }

    //Use for User/MenuForm
    protected function menuFlags(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $this->set_menu_flag()
        );
    }

    //Layout User Accessable Menu
    protected function activeMenus(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $this->set_menu_flag()
        );
    }

    protected function groupIds(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $ids = [];
                foreach ($this->groups as $group) {
                    $ids[] = $group->id;
                }
                return $ids;
            }
        );
    }

    protected function isEditable(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $this->user_type == ADMIN || $this->user_type == ENGINEER;
            }
        );
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }


    public function watch(): BelongsTo
    {
        return $this->belongsTo(Watch::class);
    }

    public function active_response_record(): HasOne
    {
        return $this->hasOne(ResponseRecord::class, 'employee_id', 'id')
            ->with('status_record.status')
            ->where('attending', true)
            ->whereHas('status_record', function ($q) {
                $q->whereNull('completed_at');
            })->orderBy('created_at', 'desc');
    }

    //Static Functions Below Here

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [];
        if (env(LOGIN_USERNAME, false)) {
            $headers[] = ['field' => 'username', 'title' => 'Employee Code', 'sortable' => true];
        }
        return array_merge($headers, [
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'user_type', 'title' => 'User Role', 'sortable' => true],
            ['field' => 'created_at', 'title' => 'Created At'],
        ]);
    }

    public function set_menu_flag($output = [], $data = [])
    {
        $user_menu = $this->menu_permission;
        $data = empty($data) ? config('menus.items') : $data;
        foreach ($data as $item) {
            $name = "";
            if (isset($item['route'])) {
                $name = substr($item['route'], 0, strrpos($item['route'], ".")); //Remove .index
            } else if (isset($item['title'])) {
                $name = $item['title'];
            }
            if ($name !== "") {
                $active = isset($user_menu[$name]) && $user_menu[$name]['active'] ? true : false;
                $output[$name] = ['active' => $active];
            }

            if (isset($item['submenus'])) {
                $output = $this->set_menu_flag($output, $item['submenus']);
            }
        }
        return $output;
    }

    public function build_menu($data = [])
    {
        $user_menu = $this->menu_permission;
        $data = empty($data) ? config('menus.items') : $data;
        if ($user_menu != null) {
            foreach ($data as $index => $item) {
                if (isset($item['route'])) {
                    //Got route
                    $name = substr($item['route'], 0, strrpos($item['route'], ".")); //Remove .index
                    if ($name != "" && isset($user_menu[$name]) && $user_menu[$name]['active'] == false) {
                        unset($data[$index]);
                    }
                } else {
                    //Title only
                    if (isset($user_menu[$item['title']]) && $user_menu[$item['title']]['active'] == false) {
                        unset($data[$index]);
                    }

                    if (isset($data[$index]['submenus'])) {
                        //Recursive
                        $data[$index]['submenus'] = array_values($this->build_menu($data[$index]['submenus']));
                    }
                }
            }
        }
        return $data;
    }

    public static function user_type_options()
    {
        return [ADMIN, ENGINEER, TECHNICIAN, OPERATOR];
    }

    public static function shift_options()
    {
        return [MORNING, NIGHT];
    }
}
