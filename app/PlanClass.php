<?php

namespace App;

use App\Model\Kangoo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanClass extends Model
{
    use HasFactory;

    public function classType(){
        return $this->hasOne(ClassType::class,'id', 'class_type_id');
    }
}
