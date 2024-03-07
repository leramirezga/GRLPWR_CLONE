<?php

namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends controller
{

    public function index()
    {
        return view('users', [
            'users' => DB::table('usuarios')->orderBy('id', 'desc')->paginate(15)
        ]);
    }

    public function search(Request $request)
    {
        $phone = $request->input('phone');
        $users = User::where('telefono', 'LIKE', "%$phone%")->get();
        return response()->json($users);
    }


}



