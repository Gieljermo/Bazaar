<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommercialController extends Controller
{
    //
    public function index()
    {
        //
        $contract = Contract::where('user_id', Auth::user()->id)->first();
        return view('commercial.index', [
            'heading' => 'Welkom '. Auth::user()->name,
            'contract' => $contract
        ]);
    }

    public function acceptContract($contract){
        try {
            $userContract = Contract::find($contract);
            $userContract->accepted = 1;
            $userContract->save();

            return redirect()->back()->with('success_message', 'Het contract is accepteerd');
        }
        catch (\Exception $e){
            return redirect()->back()->with('error_message', 'Ging iets fout met deze actie');
        }
    }

}
