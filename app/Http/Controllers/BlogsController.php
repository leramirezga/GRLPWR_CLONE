<?php

namespace App\Http\Controllers;

use App\Model\Blog;
use App\Model\Comentario;
use App\User;
use App\Utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;

class BlogsController extends Controller
{

    public function crearBlog(Request $request){
        /*Para que sepan de cual modal viene el error y poder mostrarlo*/
            $validator = Validator::make($request->all(), [
                'portada' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'titulo' => 'string|required',
                'url' => 'string|required|unique:blogs,slug|alpha_dash',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator, 'crearBlog')
                    ->withInput();
            }
        /*****************************************************************/

        $image = $request->file('portada');
        $image->storeAs('images/blogs', $request->url.'.'.$image->getClientOriginalExtension(), 'uploads');//TODO LUEGO DE ARREGLAR EL ALAMCENAMIENTO EN HEROKU QUITAR EL UPLOADS DE filesystem.php

        $blog = new Blog();
        $statement = DB::select("show table status like 'blogs'");
        $id = $statement[0]->Auto_increment;
        $blog-> usuario_id = Auth::id();
        $blog->slug = $request->url;
        $blog->portada = $request->url.'.'.$image->getClientOriginalExtension();
        $blog->titulo = $request->titulo;
        $blog->tipo = Constantes::BLOG_TIPO_BLOG;
        $blog->save();

        return redirect()->route('blog', ['blog' => $blog]);
    }

    public function editarBlog(){
        $blog = Blog::find(request()->blogID);
        $blog->contenido = request()->input('main-content');
        $blog->save();
        return $blog->id;
    }

    public function uploadImage(){
        $image = request()->image;
        $image->storeAs('images/blogs', $image->hashName(), 'uploads');//TODO LUEGO DE ARREGLAR EL ALAMCENAMIENTO EN HEROKU QUITAR EL UPLOADS DE filesystem.php
        return response()->json([
            'size' => '100',
            'url' => '../images/blogs/'.$image->hashName()
        ]);
    }

    public function insertImage(){
        return response()->json([
            'size' =>[600,600],
            'url' => request()->url,
            'alt' => 'alt',
        ]);
    }

    public function blogUsuario(User $user){
        $blogs = Blog::where('usuario_id', $user->id)->orderBy('created_at', 'desc')->get();//se debe colocar una condicion dummy en el where para poder usar el order by
        return view('blogsUsuario', compact('blogs', 'user'));
    }

    public function verBlog(Blog $blog){
        return view('blog', compact('blog'));
    }

    public function allBlogs(){
        $blogs = Blog::where('created_at', '!=', null)->orderBy('created_at', 'desc')->get();//se debe colocar una condicion dummy en el where para poder usar el order by
        return view('blogs', compact('blogs'));
    }

    public function comentarBlog(Blog $blog){
        $comentario = new Comentario;
        $comentario->blog_id = $blog->id;
        $comentario->comentario = request()->comentario;
        $user = Auth::user();
        if($user){
            $comentario->nombre = $user->nombre .' '. $user->apellido_1;
            $comentario->email = $user->email;
        }else{
            $comentario->nombre = request()->nombre;
            $comentario->email = request()->email;
        }
        $comentario->save();
        return back();
    }

    public function replyComentario(Comentario $comentario){
        $reply = new Comentario;
        $reply->blog_id = $comentario->blog_id;
        $reply->reply_id = $comentario->id;
        $reply->comentario = request()->comentario;
        $user = Auth::user();
        if($user){
            $reply->nombre = $user->nombre .' '. $user->apellido_1;
            $reply->email = $user->email;
        }else{
            $reply->nombre = request()->nombre;
            $reply->email = request()->email;
        }
        $reply->save();
        return back();
    }
}
