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
            'users' => DB::table('usuarios')
                ->join('client_plans', 'usuarios.id', '=', 'client_plans.client_id')
                ->orderBy('client_plans.expiration_date', 'desc')
                ->orderBy('usuarios.id', 'desc')
                ->select('usuarios.*', 'client_plans.expiration_date')
                ->paginate(15)
        ]);
    }

    public function search(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $needAssessment = $request->input('needAssessment');
        $expirationType = $request->input('expirationType');

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

        $query->join('client_plans', 'usuarios.id', '=', 'client_plans.client_id');
        switch ($expirationType){
            case "all":
                break;
            case "active":
                $currentDate = Carbon::today()->format('Y-m-d');
                $query->where(function ($query) use ($currentDate) {
                    $query->where('client_plans.created_at', '<=', $currentDate)
                        ->where('client_plans.expiration_date', '>=', $currentDate);
                });
                break;
            case "inactive":
                $currentDate = Carbon::today()->format('Y-m-d');
                $query->where('client_plans.expiration_date', '<=', $currentDate);
                break;
        }
        $users = $query->orderBy('client_plans.expiration_date', 'desc')
            ->select('usuarios.*', 'client_plans.expiration_date')
            ->distinct()
            ->get();
        return response()->json($users);
    }
}
