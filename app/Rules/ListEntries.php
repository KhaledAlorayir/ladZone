<?php

namespace App\Rules;

use App\Models\Game;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Log;

class ListEntries implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = collect($value);
        $unique = $value->map(fn ($value) => $value["id"])->unique();

        if ($value->count() !== $unique->count()) {
            $fail("{$attribute} must be unique");
        };

        $notRankedCount = $value->whereIn('rank', [null])->count();

        if ($notRankedCount && $notRankedCount !== $value->count()) {
            $fail("{$attribute} must all be ranked or unranked");
        }
    }
}
