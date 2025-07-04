<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = ['name', 'game_type', 'mode', 'status', 'start_date', 'end_date'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function matches()
    {
        return $this->hasMany(Contest::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
