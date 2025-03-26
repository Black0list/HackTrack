<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Hackathon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TeamController extends Controller
{


    public function index()
    {
        return response()->json(Team::all());

    }
    public function registerTeam(Request $request, $id)
    {
        Gate::allows('isCompetitor');

        try {
            $hackathon = Hackathon::find($id);

            if(!$hackathon){
                return response()->json(['error' => 'Hackathon not found'], 404);
            }

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            if ($user->team)
            {
                return response()->json(['message' => 'You have already a Team, you must leave first'], 200);
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
            $user->team()->associate($team);
            $user->save();

            return response()->json($team, 201);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }

    public function approveTeam($id)
    {
        $team = Team::find($id);

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

        $team = Team::find($id);

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

        $team = Team::find($id);

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
            $team->name = $request['name'];
            $team->save();
            return response()->json(['message' => 'Team updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $team = Team::find($id);

        if(!$team){
            return response()->json(['error' => 'Team not found'], 404);
        }

        return response()->json(['team' => $team], 200);
    }

    public function destroy($id)
    {
        $team = Team::find($id);

        if(!$team){
            return response()->json(['error' => 'Team not found'], 404);
        }

        $team->delete();
        return response()->json(['message' => 'Team deleted successfully'], 200);
    }
}
