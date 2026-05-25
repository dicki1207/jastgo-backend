<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JastiperFollower extends Model
{
    protected $fillable = ['jastiper_id', 'user_id'];

    public function jastiper()
    {
        return $this->belongsTo(Jastiper::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
