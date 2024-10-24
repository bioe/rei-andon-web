<?php

namespace App\Rules;

use App\Models\Group;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImportGroupExists implements ValidationRule
{
    protected $groupModel;

    public function __construct()
    {
        // Store the group model collection
        $this->groupModel = Group::all()->pluck('code')->toArray(); // Assuming 'name' is the column to check against
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Split the input by commas
        $groups = explode(',', rtrim($value, ','));
        // Trim and check if all groups exist in the database
        foreach ($groups as $group) {
            if (!in_array(strtoupper(trim($group)), $this->groupModel)) {
                $fail("The group '{$group}' does not exist in the system.");
            }
        }
    }
}
