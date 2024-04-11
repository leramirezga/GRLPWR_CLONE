<?php

namespace App\Http\Controllers;



use App\User;
use Carbon\Carbon;
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
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $needAssessment = $request->input('needAssessment');
        $activeClients = $request->input('activeClients');

        $query = User::query();

        if ($id) {
            $query->where('usuarios.id', $id);
        }
        if ($name) {
            $query->where('usuarios.nombre', 'LIKE', "%$name%");
        }
        if ($email) {
            $query->where('usuarios.email', 'LIKE', "%$email%");
        }
        if ($phone) {
            $query->where('usuarios.telefono', 'LIKE', "%$phone%");
        }
        if ($needAssessment === "true") {
            $query->leftJoin('physical_assessments', 'usuarios.id', '=', 'physical_assessments.user_id')
                ->where(function ($query) {
                    $query->whereNull('physical_assessments.user_id')
                        ->orWhere('physical_assessments.created_at', '<', Carbon::today()->subMonths(MONTHS_FOR_NEW_HEALTH_ASSESSMENT)->format('Y-m-d'));
                });
        }
        if ($activeClients === "true") {
            $currentDate = Carbon::today()->format('Y-m-d');
            $query->join('client_plans', 'usuarios.id', '=', 'client_plans.client_id')
                ->where(function ($query) use ($currentDate) {
                    $query->where('client_plans.created_at', '<=', $currentDate)
                        ->where('client_plans.expiration_date', '>=', $currentDate);
                });
        }

        $users = $query->orderBy('usuarios.id', 'desc')
        ->select('usuarios.*')->distinct()->get();
        return response()->json($users);
    }
}
