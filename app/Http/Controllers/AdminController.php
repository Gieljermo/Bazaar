<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    //

    public function index()
    {
        //
        $users = User::all()->except(Auth::id());
        $roles = Role::all()->except(Auth::user()->role_id);

        return view('admin.index', [
                'heading' => 'Welkom '. Auth::user()->name,
                'users' => $users,
                'roles' => $roles,
                'roleActive' => 0
            ]);
    }

    public function filterUsers($roleName){
        try {
            $role_id = Role::where('role_name', $roleName)->value('id');
            $users = User::whereRaw('role_id = ?', $role_id)->get();

            $roles = Role::all()->except(Auth::user()->role_id);

            return view('admin.index', [
                'heading' => 'Welkom '. Auth::user()->name,
                'users' => $users,
                'roles' => $roles,
                'roleActive' => $roleName
            ]);
        }
        catch (\Exception $e){
            return redirect()->route('admin.index');
        }

    }

    public function exportContractPdf($user){
        $chosenUser = User::find($user);
        $pdf = Pdf::loadView('admin.contract', [
            'user' => $chosenUser
        ]);
        return $pdf->download("contract_".$chosenUser->name.".pdf");
    }

    public function uploadContract(Request $request, $user){
        try {
            $request->validate([
                'contract' => 'required|file|mimes:pdf|'
            ]);

            $file = $request->file('contract');
            $fileData = file_get_contents($file);

            $contract = Contract::where('user_id', $user)->first();
            $contract->file = $fileData;
            $contract->save();

            return redirect()->back()->with('success_message', 'Bestand succesvol geupload');
        }
        catch (\Exception $e){
            return redirect()->back()->with('error_message', 'Bestand kon niet geupload worden');
        }
    }
}
