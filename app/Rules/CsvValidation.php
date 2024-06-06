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
        $csvData = [];

        foreach ($data as $key => $row) {
            if (count($header) != count($row)) {
                // Identify the missing columns by comparing the header length with the row length
                $missingColumns = array_diff($header, array_slice($header, 0, count($row)));
                $countingRow = $key + 1;
                $fail("Rij ($countingRow): niet alle kolommen zijn aanwezig");
                return;
            }

            $csvData[] = array_combine($header, $row);
        }

        // Validate each row
        $listErrors = [];
        foreach ($csvData as $key => $row) {
            $validator = Validator::make($row, [
                'product_name' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string',
                'price' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $listErrors[$key + 1] = $validator->errors()->all();
            }
        }

        foreach ($listErrors as $key => $errors) {
            foreach ($errors as $error) {
                $fail("Row {$key}: {$error}");
            }
        }
    }
}
