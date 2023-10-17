<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class JsonLinesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $lines = explode("\n", $value->get());

        $emptyLines = collect($lines)->filter(fn (string $line) => $line === '');

        if ($emptyLines->count() > 1) {
            $fail('The file contains more than one empty line');
        }

        if (count($lines) < 11) {
            $fail('The file must have at least 10 lines');
        }

        foreach ($lines as $line) {
            if ($line === '') {
                continue;
            }

            json_decode($line);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $fail('The file contains a invalid JSONL');
            }
        }
    }
}
