<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Players;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PlayersController extends Controller
{
    public function index()
    {
        $players = Players::all();
        $data = [
            'message' => 'Players retrieved successfully',
            'status' => 200,
            'players' => $players
        ];
        if ($players->isEmpty()) {
            $data = [
                'message' => 'No players found',
                'status' => 404,
                'players' => $players
            ];
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:players,email',
            'rating' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation failed',
                'status' => 422,
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        }
        
        $players = Players::create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating ?? 1000 // Default rating if not provided
        ]);

        if (!$players) {
            $data = [
                'message' => 'Failed to create player',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Player created successfully',
            'status' => 201,
            'player' => $players
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $player = Players::find($id);

        $data = [
            'message' => 'Player retrieved successfully',
            'status' => 200,
            'player' => $player
        ];

        if (!$player) {
            $data = [
                'message' => 'Player not found',
                'status' => 404
            ];
        }

        
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $player = Players::find($id);

        if (!$player) {
            $data = [
                'message' => 'Player not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:players,email,' . $id,
            'rating' => 'sometimes|nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation failed',
                'status' => 422,
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        }

        $player->update($request->only('name', 'email', 'rating'));

        $data = [
            'message' => 'Player updated successfully',
            'status' => 200,
            'player' => $player
        ];

        return response()->json($data);
    }
}
