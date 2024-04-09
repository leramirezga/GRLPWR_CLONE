<h3 class="theme-color d-inline-block mr-1 mb-3">comments [<span
            style="color: tomato">{{$user->comments->count()}}</span>]</h3>
@for ($i = 0; $i < $user->comments->count(); $i++)
    <div class="themed-block p-3 mb-3 text-justify">
        <h3><strong>{{$user->comments[$i]->commenter->nombre}}</strong></h3>
        <p class="mb-0">{{$user->comments[$i]->comment}}</p>
        <a class="cursor-pointer unselectable" style="color: rgba(0, 0, 0, 0.8)" data-toggle="collapse"
           data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">reply</a>
        @if($user->comments[$i]->replies->count() > 0)
            <a class="cursor-pointer unselectable d-block ml-2" style="color: rgba(0, 0, 0, 0.8)"
               data-toggle="collapse" data-target="#collapseReplies{{$i}}" aria-expanded="false"
               aria-controls="collapseReplies{{$i}}">{{$user->comments[$i]->replies->count()}} replies</a>
        @endif
        <div id="collapse{{$i}}" aria-expanded="false" class="collapse ml-5 mt-3">
            <form id="replyForm{{$i}}" method="POST"
                  action="{{route('replyUserComment', ['comment'=>$user->comments[$i]])}}"
                  autocomplete="off">
                @csrf
                <textarea required name="comment" placeholder="Escribe un comentario" style="font-size: 20px"
                          maxlength="140" class="form-control h-auto mb-3"
                          rows="3"></textarea>
                <div class="clearfix">
                    <button class="btn themed-btn float-right">Comentar</button>
                </div>
            </form>
        </div>
        <div id="collapseReplies{{$i}}" aria-expanded="false" class="collapse ml-5 mt-3">
            @foreach($user->comments[$i]->replies as $reply)
                <div style="border-left: solid 1px tomato; padding-left: 3vh" class="mb-4">
                    <h3><strong>{{$reply->commenter->nombre}}</strong></h3>
                    <p class="mb-0">{{$reply->comment}}</p>
                </div>
            @endforeach
        </div>
    </div>
@endfor
<hr class="mt-4 mb-4" style="border: solid 1px rgba(0,0,0,0.2);"/>
<form id="commentForm" method="POST" action="{{route('commentUser', ['user'=>$user])}}" autocomplete="off">
    @csrf
    <textarea required name="comment" placeholder="Escribe un comentario" style="font-size: 20px"
              maxlength="140" class="form-control h-auto mb-3"
              rows="3"></textarea>
    <div class="clearfix mb-5">
        <button class="btn themed-btn float-right">Comentar</button>
    </div>
</form>