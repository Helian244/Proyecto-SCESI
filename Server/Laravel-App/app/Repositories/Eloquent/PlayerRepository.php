<?php

namespace App\Repositories\Eloquent;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryInterface;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function all() {
        return Player::all();
    }

    public function find($id) {
        return Player::find($id);
    }

    public function create(array $data) {
        if (!isset($data['rating']) || $data['rating'] === null) {
            $data['rating'] = 1000;
        }
        return Player::create($data);
    }

    public function update($id, array $data) {
        $player = Player::findOrFail($id);
        $player->update($data);
        return $player;
    }

    public function delete($id) {
        return Player::destroy($id);
    }
}
