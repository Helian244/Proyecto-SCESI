<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Players;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Repositories\Contracts\PlayerRepositoryInterface;

class PlayerController extends Controller
{
    protected $repo;

    public function __construct(PlayerRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json([
            'message' => 'Successfully retrieved players',
            'data' => $this->repo->all()
        ]);
    }

    public function store(StorePlayerRequest $request)
    {
        $player = $this->repo->create($request->validated());
        return response()->json([
            'player' => $player,
        ], 201);
    }

    public function show($id)
    {
        $player = $this->repo->find($id);
        if (!$player) {
            return response()->json(['message' => 'Player not found'], 404);
        }
        return response()->json([
            'player' => $player
        ]);
    }

    public function update(UpdatePlayerRequest $request, $id)
    {
        try {
            $player = $this->repo->update($id, $request->validated());
            return response()->json([
                'player' => $player
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Player not found'], 404);
        }
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json(['message' => 'Player deleted successfully']);
    }
}
