<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //protected $table = "reviews";//sobra porque si cumple la convencion

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reviewer_id','rating','review','usuario_id'
    ];

    public function tiempo(){
        return (Carbon::parse($this->created_at)->diffForHumans());
    }

    public function reviewer(){
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }

}
