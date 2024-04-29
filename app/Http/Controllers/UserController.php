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
        $assigned = $request->input('assigned');
        $expirationType = $request->input('expirationType');

        $query = User::query();

        if ($id) {
            $query->where('usuarios.id', $id);
        }
        if ($name) {
            $query->where(function ($query) use ($name) {
                $query->where('usuarios.nombre', 'LIKE', "%$name%")
                    ->orWhere('usuarios.apellido_1', 'LIKE', "%$name%")
                    ->orWhere('usuarios.apellido_2', 'LIKE', "%$name%");
            });
        }
        if ($email) {
            $query->where('usuarios.email', 'LIKE', "%$email%");
        }
        if ($assigned) {
            $query->where('usuarios.assigned_id', 'LIKE', "%$assigned%");
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
        $currentDate = Carbon::today();
        switch ($expirationType){
            case "all":
                $query->leftJoin('client_plans', 'usuarios.id', '=', 'client_plans.client_id');
                break;
            case "active":
                $query->join('client_plans', function ($join) use ($currentDate) {
                    $join->on('usuarios.id', '=', 'client_plans.client_id')
                        ->where('client_plans.expiration_date', '>=', $currentDate->copy()->startOfDay());
                });
                break;
            case "inactive":
                $query->join('client_plans', function ($join) use ($currentDate) {
                    $join->on('usuarios.id', '=', 'client_plans.client_id')
                        ->where('client_plans.expiration_date', '<', $currentDate->copy()->startOfDay());
                });
                break;
        }
        $users = $query->selectRaw('usuarios.*, MAX(expiration_date) as expiration_date')
            ->orderBy('expiration_date', 'DESC')
            ->groupBy('usuarios.id')
            ->get();
        return response()->json($users);
    }
}
