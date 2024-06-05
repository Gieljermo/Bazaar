<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class CsvValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = array_map('str_getcsv', file($value->getRealPath()));
        $header = array_shift($data);

        $csvData = array_map(function($row) use ($header) {
            return array_combine($header, $row);
        }, $data);

        //validate each row
        $listErrors = [];
        foreach ($csvData as $key => $row) {
            $validator = Validator::make($row, [
                'product_name' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string',
                'price' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $listErrors[$key] = $validator->errors()->all();
            }
        }

        foreach ($listErrors as $key => $errors) {
            foreach ($errors as $error) {
                $fail("Row {$key}: {$error}");
            }
        }
    }
}
