<?php

namespace App\Rules;

use App\Models\Watch;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImportWatchExists implements ValidationRule
{
    protected $model;

    public function __construct()
    {
        // Store the model collection
        $this->model = Watch::where('active', true)->get()->pluck('code')->toArray(); // Assuming 'name' is the column to check against
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (!in_array(strtoupper(trim($value)), $this->model)) {
            $fail("The watch code '{$value}' does not exist in the system.");
        }
    }
}
