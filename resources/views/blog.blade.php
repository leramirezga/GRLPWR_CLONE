@extends('layouts.app')

@section('title')
    {{$blog->titulo}}
@endsection

@section('head-content')

    <meta property="og:url" content="https://{{@lang('general.AppName')}}/blog/{{$blog->slug}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$blog->titulo}}"/>
    <meta property="og:image" content="{{env('APP_URL')}}/images/blogs/{{$blog->portada}}"/>
    <meta property="og:image:alt" content="{{$blog->portada}}">
    <meta property="fb:app_id" content="364663920399879">
    <!--<meta property="og:description"        content="How much does culture influence creative thinking?" />Esta no se tiene en los blogs-->

    <link rel="stylesheet" type="text/css" href="{{asset('wysiwyg/content-tools.min.css')}}">}
    <link rel="stylesheet" type="text/css" href="{{asset('css/blog.css')}}">

@endsection

@section('content')
    <div class="container-fluid">
        @csrf

        <div data-editable data-name="main-content" class="m-auto mb-5 blog">
            <input type="hidden" name="blogID" id="blogID" value="{{$blog->id}}">
            @if(isset($blog->contenido))
                {!! $blog->contenido !!}
            @else
                <h1 class="text-center" style="margin-bottom: 1.5em">
                    ¿Cómo crear un blog?
                </h1>
                <p>Da click en el lapiz arriba a la derecha y comienza a crear tu blog.</p>
                <p class="nota"><strong>Nota:</strong> Puedes seleccionar estilos predeterminados, como el de esta nota,
                    haciendo click en el botón de abajo a la izquierda </p>

                <img alt="preformat crear blog" height="400" width="800" src="{{asset('images/preformat.png')}}">

                <p>Para crear nuevos elementos edita uno existente y presiona <strong>ENTER</strong> al final.
                    Luego selecciona el tipo de elemento que deseas de la paleta de edición </p>
            @endif
        </div>

        <div style="width: max-content">
            <hr class="mb-4" style="border: solid 1px rgba(255,255,255,0.5); margin-top: 30vh!important;"/>
            <h2 class="color-white d-inline-block mr-3 mb-0" style="vertical-align: middle">Compartir</h2>
            <a href="http://www.facebook.com/sharer.php?u={{env('APP_URL')}}/blog/{{$blog->slug}}"
               target="_blank">
                <img class="mr-3" src="{{asset('images/facebook.png')}}" width="50">
            </a>
        </div>
        <hr class="mt-4 mb-4" style="border: solid 1px rgba(255,255,255,0.5);"/>
        <h3 class="color-white d-inline-block mr-1 mb-3">Comentarios [<span
                    style="color: tomato">{{$blog->comentarios->count()}}</span>]</h3>
        @for ($i = 0; $i < $blog->comentarios->count(); $i++)
            <div class="floating-card bg-dark p-3 mb-3">
                <h3><strong>{{$blog->comentarios[$i]->nombre}}</strong></h3>
                <p class="mb-0">{{$blog->comentarios[$i]->comentario}}</p>
                <a class="cursor-pointer unselectable" style="color: rgba(255, 255, 255, 0.5)" data-toggle="collapse"
                   data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">reply</a>
                @if($blog->comentarios[$i]->replies->count() > 0)
                    <a class="cursor-pointer unselectable d-block ml-2" style="color: rgba(255, 255, 255, 0.5)"
                       data-toggle="collapse" data-target="#collapseReplies" aria-expanded="false"
                       aria-controls="collapseReplies">{{$blog->comentarios[$i]->replies->count()}} replies</a>
                @endif
                <div id="collapse{{$i}}" aria-expanded="false" class="collapse ml-5 mt-3">
                    <form id="replyForm{{$i}}" method="POST"
                          action="{{route('replyComentario', ['comentario'=>$blog->comentarios[$i]])}}"
                          autocomplete="off">
                        @csrf
                        <textarea required name="comentario" placeholder="Escribe un comentario" style="font-size: 20px"
                                  maxlength="140" class="form-control h-auto mb-3"
                                  rows="3">{{ old('descripcion', !empty($solicitud) ? $solicitud->descripcion : '') }}</textarea>
                        @if(!\Illuminate\Support\Facades\Auth::user())
                            <div class="mb-3 mb-md-0">
                                <input required placeholder="Nombre" name="nombre"
                                       class="col-md-4 p-3 mr-md-3 mb-3 mb-md-0">
                                <input required placeholder="Email" name="email" class="col-md-4 p-3">
                            </div>
                        @endif
                        <div class="clearfix">
                            <button class="btn btn-success float-right">Comentar</button>
                        </div>
                    </form>
                </div>
                <div id="collapseReplies" aria-expanded="false" class="collapse ml-5 mt-3">
                    @foreach($blog->comentarios[$i]->replies as $reply)
                        <div style="border-left: solid 1px tomato; padding-left: 3vh" class="mb-4">
                            <h3><strong>{{$reply->nombre}}</strong></h3>
                            <p class="mb-0">{{$reply->comentario}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endfor
        <hr class="mt-4 mb-4" style="border: solid 1px rgba(255,255,255,0.2);"/>
        <form id="comentarForm" method="POST" action="{{route('comentarblog', ['blog'=>$blog])}}" autocomplete="off">
            @csrf
            <textarea required name="comentario" placeholder="Escribe un comentario" style="font-size: 20px"
                      maxlength="140" class="form-control h-auto mb-3"
                      rows="3">{{ old('descripcion', !empty($solicitud) ? $solicitud->descripcion : '') }}</textarea>
            @if(!\Illuminate\Support\Facades\Auth::user())
                <div class="mb-3 mb-md-0">
                    <input required placeholder="Nombre" name="nombre" class="col-md-4 p-3 mr-md-3 mb-3 mb-md-0">
                    <input required placeholder="Email" name="email" class="col-md-4 p-3">
                </div>
            @endif
            <div class="clearfix mb-5">
                <button class="btn btn-success float-right">Comentar</button>
            </div>
        </form>

        @if($blog->usuario_id == \Illuminate\Support\Facades\Auth::id())
            <!--para que el contenido de la página se pueda editar-->
            <script src="{{asset('wysiwyg/content-tools.min.js')}}"></script>
            <script src="{{asset('wysiwyg/editor.js')}}"></script>
        @endif
    </div>

@endsection
