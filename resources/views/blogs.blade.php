@extends('cliente.clienteTemplate')

@section('title') Blogs @endsection

@section('head-content')

    <!-- Se debe poner esta de nuevo para que funcion el tooltip (SE QUITÓ PORQUE NO VEO NADA CON TOOLTIP Y ESTO CAUSA QUE LOS DROPDOWN NO APAREZCAN AL PRIMER CLICK)
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>-->

    <link rel="stylesheet" href="{{asset('css/busquedaClientes.css')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />

    <link rel="stylesheet" type="text/css" href="{{asset('css/blog.css')}}">
@endsection

@section('content')

    <div class="container-fluid w-100">
        <h1 class="text-center">Blogs relevantes</h1>
        <div class="row justify-content-around w-100 m-0">
        @foreach($blogs as $blog)
            <div class="card col-md-5 d-inline-block m-5 p-0 floating-card bg-dark">
                @if($blog->tipo == \App\Utils\Constantes::BLOG_TIPO_BLOG)
                    <a href="/blog/{{$blog->slug}}">
                        <img class="card-img-top" src="/images/blogs/{{$blog->portada}}" style="height: 75%">
                    </a>
                @endif
                <a href="/blog/{{$blog->slug}}">
                <div class="card-body text-center d-flex" style="height: 25%; overflow: hidden; padding:10px">
                    <span class="m-auto color-white" style="overflow: hidden; max-height: 100%; font-size: 24px">{{$blog->titulo}}</span>
                </div>
                </a>
            </div>
        @endforeach
        </div>
    </div>

@endsection
