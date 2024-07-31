<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalActiveClient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'date',
        'active_clients',
        'active_new_clients',
        'active_old_clients',
        'retained_clients',
        'percent_retained_clients'
    ];
}
