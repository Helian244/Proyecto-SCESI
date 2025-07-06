<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Repositories\Contracts\TournamentRepositoryInterface;

class TournamentController extends Controller
{
    protected $repo;

    public function __construct(TournamentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json(['tournaments' => $this->repo->all()]);
    }

    public function show($id)
    {
        $tournament = $this->repo->find($id);
        if (!$tournament) {
            return response()->json(['message' => 'Tournament not found'], 404);
        }
        return response()->json(['tournament' => $tournament]);
    }

    public function store(StoreTournamentRequest $request)
    {
        $tournament = $this->repo->create($request->validated());
        return response()->json(['tournament' => $tournament], 201);
    }

    public function update(UpdateTournamentRequest $request, $id)
    {
        $tournament = $this->repo->update($id, $request->validated());
        if (!$tournament) {
            return response()->json(['message' => 'Tournament not found'], 404);
        }
        return response()->json(['tournament' => $tournament]);
    }

    public function destroy($id)
    {
        $tournament = $this->repo->delete($id);
        if (!$tournament) {
            return response()->json(['message' => 'Tournament not found'], 404);
        }
        return response()->json(['message' => 'Tournament deleted']);
    }
}
