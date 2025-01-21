<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\User;
use App\Models\Watch;
use App\Rules\ImportGroupExists;
use App\Rules\ImportUnique;
use App\Rules\ImportWatchExists;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\PersistRelations;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class FirstUsersSheet implements OnEachRow, WithStartRow, WithUpserts, WithUpsertColumns, WithValidation, WithHeadingRow, PersistRelations
{
    public $groups;
    public function __construct()
    {
        //Prevent query in each row
        $this->groups = Group::get()->keyBy('code');
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $orignal_row)
    {
        //$rowIndex = $orignal_row->getIndex();
        $row = $orignal_row->toArray();

        $watch = Watch::where('code', $row['watch_code'])->select(['id'])->first();

        $user = User::updateOrCreate(
            ['username' => $row['employee_code']], // use this to check exists or not
            [
                'username' => $row['employee_code'],
                'name' => $row['name'],
                'badge_no' => $row['badge_no'] ?? null,
                'user_type' => $row['user_role'],
                'password' => Hash::make($row['employee_code']), //IF is INSERT create password same as username, else only upsertColumns specified column
                'watch_id' => $watch->id ?? null
            ]
        );

        //Link the Group by ID
        $group_ids = [];
        $group_text = rtrim(trim($row['groups'], ","));
        if (!empty($group_text)) {
            $group_arrays = explode(",", $group_text);
            foreach ($group_arrays as $g) {
                $group_ids[] =  $this->groups[strtoupper(trim($g))]->id;
            }
        }
        $user->groups()->sync($group_ids);
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
     * Upsert
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'username';
    }

    /**
     * WithUpsertColumns
     * @return array
     */
    public function upsertColumns()
    {
        return ['username', 'name', 'badge_no', 'user_type', 'watch_id'];
    }

    public function rules(): array
    {
        return [
            'employee_code' => ['required'],
            'name' => ['required'],
            'badge_no' => ['nullable'],
            'user_role' => ['required', Rule::in(User::user_type_options())],
            'groups' => ['nullable', new ImportGroupExists],
            'watch_code' => ['nullable', new ImportWatchExists],
        ];
    }
}
