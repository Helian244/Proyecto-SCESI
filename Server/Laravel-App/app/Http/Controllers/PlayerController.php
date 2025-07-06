<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Players;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FilterPlayerRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\StoreManyPlayersRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Repositories\Contracts\PlayerRepositoryInterface;

class PlayerController extends Controller
{
    protected $repo;

    public function __construct(PlayerRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $id = $request->query('id');
        if ($id) {
            $player = $this->repo->find($id);
            if (!$player) {
                return response()->json(['message' => 'Player not found'], 404);
            }   
            return response()->json(['player' => $player]);
        }

        return response()->json([
            'message' => 'Successfully retrieved players',
            'data' => $this->repo->all()
        ]);
    }

    public function filter(FilterPlayerRequest $request)
    {
        $query = $this->repo->filter($request);

        $players = $query->paginate(6);

        return response()->json([
            'message' => 'Filtered players successfully',
            'data' => $players
        ]);
    }

    public function store(StorePlayerRequest $request)
    {
        $player = $this->repo->create($request->validated());
        return response()->json([
            'player' => $player,
        ], 201);
    }

    public function storeMany(StoreManyPlayersRequest $request)
    {
        $created = [];

        foreach ($request->validated() as $playerData) {
            $created[] = $this->repo->create($playerData);
        }

        return response()->json([
            'message' => 'Multiple players created successfully',
            'players' => $created
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
