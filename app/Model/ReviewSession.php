<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReviewSession extends Model
{
    protected $table = "reviews_session";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_id', 'session_id'
    ];
}
