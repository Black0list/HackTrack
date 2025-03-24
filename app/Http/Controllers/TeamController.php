<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Hackathon;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TeamController extends Controller
{
    public function registerTeam(Request $request, Hackathon $hackathon)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'github_link' => 'required|url|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $team = new Team();
            $team->name = $request->name;
            $team->github_link = $request->github_link;
            $team->hackathon_id = $hackathon->id;
            $team->status = 'rejected';
            $team->save();

            return response()->json($team, 201);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }

    public function approveTeam(Team $team)
    {
        $team->status = 'approved';
        $team->save();

        return response()->json(['message' => 'Team approved successfully']);
    }

    public function rejectTeam(Team $team)
    {
        $team->status = 'rejected';
        $team->save();

        return response()->json(['message' => 'Team rejected successfully']);
    }
}
