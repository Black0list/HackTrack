<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Hackathon;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TeamController extends Controller
{
    public function registerTeam(Request $request, $id)
    {
        try {
            $hackathon = Hackathon::findOrfail($id);

            if(!$hackathon){
                return response()->json(['error' => 'Hackathon not found'], 404);
            }

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
            $team->hackathon()->associate($hackathon);
            $team->status = 'rejected';
            $team->save();

            return response()->json($team, 201);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }

    public function approveTeam($id)
    {

        $team = Team::findOrfail($id);

        if(!$team){
            return response()->json(['error' => 'Team not found'], 404);
        }

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

    public function joinTeam($id)
    {

        $team = Team::findOrfail($id);

        if(!$team){
            return response()->json(['error' => 'Team not found'], 404);
        }

        $user = JWTAuth::parseToken()->authenticate();

        try {
            $user->team()->associate($team);
            $user->save();
            return response()->json(['message' => $user->name . ' Successfully Joined Team ' . $team->name], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {

        $team = Team::findOrfail($id);

        if(!$team){
            return response()->json(['error' => 'Team not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'github_link' => 'required|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        try {
            $team->name = $validator['name'];
            $team->save();
            return response()->json(['message' => 'Team updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
