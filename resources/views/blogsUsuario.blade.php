@extends('layouts.app')

@section('title')
    Blogs {{$user->nombre}}
@endsection

@section('head-content')

    <link rel="stylesheet" type="text/css" href="{{asset('css/blog.css')}}">

@endsection

@section('content')

    @include('crearBlogModal')

    <div class="container-fluid">

        @if($blogs->count()==0)
            <div class="margenes-normales floating-card bg-semi-transparent text-center">
                <p class="d-inline-block">Aún no hay ningún blog.</p>
                @if($user == \Illuminate\Support\Facades\Auth::user())
                    <button type="button" class="btn themed-btn m-auto d-inline-block d-md-block" data-toggle="modal"
                            data-target="#crearInfoBlogModal">Crear Blog
                    </button>
                @endif
            </div>
        @elseif($user == \Illuminate\Support\Facades\Auth::user())
            <button type="button" class="btn themed-btn m-auto d-inline-block d-md-block" data-toggle="modal"
                    data-target="#crearInfoBlogModal">Crear Blog
            </button>
        @endif
        <div class="timeline">
            @for($i = 0; $i < $blogs->count(); $i++)
                <div class='timeline-container @if($i%2==0) left @else right @endif'>
                    <div class="card floating-card bg-dark">
                        @if($blogs[$i]->tipo == \App\Utils\Constantes::BLOG_TIPO_BLOG)
                            <a href="/blog/{{$blogs[$i]->slug}}">
                                <img class="card-img-top" src="/images/blogs/{{$blogs[$i]->portada}}"
                                     style="height: 37.5vh;">
                            </a>
                        @endif
                        <a href="/blog/{{$blogs[$i]->slug}}">
                            <div class="card-body text-center d-flex" style="height: 12.5vh; padding:10px">
                                <span class="m-auto"
                                      style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 100%; font-size: 24px">{{$blogs[$i]->titulo}}</span>
                            </div>
                        </a>
                    </div>
                </div>
            @endfor
        </div>
    </div>

@endsection
