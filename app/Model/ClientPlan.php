<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    use HasFactory;
    protected $table = 'client_plan';

    /**
     * Transforms dates to carbon
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at', 'expiration_date'];

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

}
