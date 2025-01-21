<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImportUnique implements ValidationRule
{
    protected $seenValues = [];
    protected $columnName;

    public function __construct($columnName)
    {
        $this->columnName = $columnName;
        $this->seenValues = [];
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $normalizedValue = strtoupper(trim($value));

        if (in_array($normalizedValue, $this->seenValues)) {
            $fail("The {$this->columnName} '{$value}' appears multiple times in your import file.");
            return;
        }

        $this->seenValues[] = $normalizedValue;
        \Log::info($this->seenValues);
    }
}
