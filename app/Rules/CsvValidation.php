<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CsvValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        $listErrors = [];
        $fileContents = file($value->getPathname());

        foreach ($fileContents as $lineNumber => $content){
            $getCsv = str_getcsv($content);

            if(empty($getCsv[0])){
                $listErrors[] = "Er mist een product naam op regel " . ($lineNumber + 1);
            }

            if(empty($getCsv[1])){
                $listErrors[] = "Er mist een product beschrijving op regel " . ($lineNumber + 1);
            }

            if(empty($getCsv[2])){
                $listErrors[] = "Er mist een product type op regel " . ($lineNumber + 1);
            }

            if(empty($getCsv[3])){
                $listErrors[] = "Er mist een product prijs op regel " . ($lineNumber + 1);
            }

            if($listErrors != null){
                break;
            }
        }

        foreach ($listErrors as $error) {
            $fail($error);
        }
    }
}
