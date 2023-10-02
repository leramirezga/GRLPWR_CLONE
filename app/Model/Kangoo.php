<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kangoo extends Model
{
    protected $table = 'kangoos';
    use SoftDeletes;
}
