<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;

class ListingTypeLimit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $listingCount = Listing::where('user_id', Auth::user()->id)->where('type', $value)->where('ended', 0)->where('purchase_id', null)->count();

        if($listingCount >= 4){
            $fail('Je mag maar 4 advertenties met dit type tegelijk open hebben staan');
        }
    }
}
