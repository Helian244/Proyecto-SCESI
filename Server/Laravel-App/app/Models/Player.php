<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'email', 'rating'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function matchesAsPlayer1()
    {
        return $this->hasMany(Contest::class, 'player1_id');
    }

    public function matchesAsPlayer2()
    {
        return $this->hasMany(Contest::class, 'player2_id');
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
