<?php

namespace App\Http\Controllers;

use App\User;
use App\UserComment;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserCommentController extends Controller
{

    public function comment(User $user){
        $comment = new UserComment();
        $comment->user_id = $user->id;
        $comment->comment = request()->comment;
        $comment->commenter_id = Auth::id();
        $comment->save();
        return back();
    }

    public function reply(UserComment $comment){
        $reply = new UserComment();
        $reply->user_id = $comment->user_id;
        $reply->reply_id = $comment->id;
        $reply->comment = request()->comment;
        $reply->commenter_id = Auth::id();
        $reply->save();
        return back();
    }
}
