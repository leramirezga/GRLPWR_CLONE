<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReviewUser extends Model
{
    protected $table = "reviews_user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_id', 'user_id'
    ];
}
