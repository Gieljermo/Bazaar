<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AtLeastOneFilled implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valueFound = false;

        if (is_array($value)) {
            foreach ($value as $item) {
                foreach ($item as $itemValue) {
                    if (!is_null($itemValue)) {
                        $valueFound = true;
                    }
                }
            }
        }

        if(!$valueFound){
            $fail('Er moet minimaal 1 :attribute veld worden gevuld.');
        }
    }
}
