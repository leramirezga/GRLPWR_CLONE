<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Socialite;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
    // Metodo encargado de la redireccion a Facebook
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider)
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->stateless()->user();

        // Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($user); // Login y redirección
        } else {// En caso de que no exista creamos un nuevo usuario con sus datos.
            $splitName = explode(' ', $social_user->name, 2);
            $nombre = $splitName[0];
            $apellido= !empty($splitName[1]) ? $splitName[1] : '';

            $statement = DB::select("show table status like 'usuarios'");
            $id = $statement[0]->Auto_increment;

            $user = User::create([
                'nombre' => $nombre,
                'apellido_1' => $apellido,
                'email' => $social_user->email,
                'nivel' => 0,
                'foto' => $id,
                'slug' => $id,//por defecto se coloca el id como la URL (slug) inicial
                'rol' => "indefinido"
            ]);
            $foto = file_get_contents($social_user->avatar_original);
            Storage::disk('uploads')->put('images/avatars/'.$user->id,$foto);//TODO LUEGO DE ARREGLAR EL ALAMCENAMIENTO EN HEROKU QUITAR EL UPLOADS DE filesystem.php

            return $this->authAndRedirect($user); // Login y redirección
        }
    }

    // Login y redirección
    public function authAndRedirect($user)
    {
        Auth::login($user);

        return redirect()->to('/user/'.$user->slug.'/home');
    }
}
