<?php

namespace App\Repositories\Eloquent;

use App\Models\Tournament;
use App\Repositories\Contracts\TournamentRepositoryInterface;

class TournamentRepository implements TournamentRepositoryInterface
{
    public function all() {
        return Tournament::all();
    }

    public function find($id) {
        return Tournament::find($id);
    }

    public function create(array $data) {
        return Tournament::create($data);
    }

    public function update($id, array $data)
    {
        $tournament = Tournament::find($id);
        if ($tournament) $tournament->update($data);
        return $tournament;
    }
    
    public function delete($id)
    {
        $tournament = Tournament::find($id);
        if ($tournament) $tournament->delete();
        return $tournament;
    }
}