<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemainingClass extends Model
{
    use HasFactory;

    public function classType(){
        return $this->hasOne(ClassType::class,'id', 'class_type_id');
    }
}
