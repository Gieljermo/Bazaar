<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Listing;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class CommercialController extends Controller
{
    //

    public function getContract()
    {
        $contract = Contract::where('user_id', Auth::user()->id)->first();
        return view('commercial.contract',[
            'heading' => 'Welkom '. Auth::user()->name,
            'contract' => $contract
        ]);
    }

    public function downloadContract($id){
        $contract = Contract::find($id);

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="contract-'.Auth::user()->name.'"',
        ];

        return Response::make($contract->file, 200, $headers);
    }

    public function acceptContract($contract){
        try {
            $userContract = Contract::find($contract);
            $userContract->accepted = 1;
            $userContract->save();

            return redirect()->back();
        }
        catch (\Exception $e){
            return redirect()->back()->with('error_message', 'Ging iets fout met deze actie');
        }
    }

    public function dataToJson(Request $request)
    {
            $data = Listing::where([
                ['user_id', $request->user()->id],
                ['purchase_id', null],
            ])->with('product')->get();


            return response()->json($data);
    }
}
