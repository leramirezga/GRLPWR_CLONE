<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';

    /**
     * Transforms dates to carbon
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at', 'expiration_date'];

}
