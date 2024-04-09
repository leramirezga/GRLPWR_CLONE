<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    use HasFactory;

    public function replies($orden = 'asc'){
        return $this->hasMany(UserComment::class, 'reply_id', 'id')->orderBy('created_at', $orden);
    }

    public function commenter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'commenter_id');
    }
}
