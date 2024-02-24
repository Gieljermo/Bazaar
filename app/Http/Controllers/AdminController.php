<?php

namespace App\Http\Controllers;

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


    public function filterUsers($role){
        try {

            $users = User::whereRaw('role_id = ?', $role)->get();
            $roles = Role::all()->except(Auth::user()->role_id);

            return view('admin.index', [
                'heading' => 'Welkom '. Auth::user()->name,
                'users' => $users,
                'roles' => $roles,
                'roleActive' => (int)$role
            ]);
        }
        catch (\Exception $e){
            return redirect('admin.index');
        }

    }

    public function exportContractPdf($user){
        $chosenUser = User::find($user);
        $pdf = Pdf::loadView('admin.contract', [
            'user' => $chosenUser
        ]);
        return $pdf->download("contract_".$chosenUser->name.".pdf");
    }
}
