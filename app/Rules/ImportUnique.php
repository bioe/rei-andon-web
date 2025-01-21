<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImportUnique implements ValidationRule
{
    private static $seenWatchCodes = [];
    private $row;

    public function __construct(int $row)
    {
        $this->row = $row;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Skip if watch_code is empty/null
        if (empty($value)) {
            return;
        }

        $watchCode = trim($value);

        if (isset(self::$seenWatchCodes[$watchCode])) {
            $fail("Duplicate Watch Code '{$watchCode}' found. Please remove it.");
        } else {
            self::$seenWatchCodes[$watchCode] = $this->row;
        }
    }
}
