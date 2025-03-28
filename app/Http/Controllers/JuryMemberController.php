<?php

namespace App\Http\Controllers;

use App\Models\Jury;
use App\Models\JuryMember;
use App\Models\Note;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JuryMemberController extends Controller
{
    public function index()
    {
        return response()->json(JuryMember::all());
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $jury = Jury::find($id);

        if (!$jury) {
            return response()->json(['message' => 'Jury not found'], 404);
        }

        $username = 'juryMember_'.$request->get('username');
        $pin = Str::random(15);

        $juryMember = new JuryMember();
        $juryMember->username = $username;
        $juryMember->password = $pin;
        $juryMember->jury()->associate($jury);

        $juryMember->save();

        return response()->json($juryMember);
    }

    public function update(Request $request, $id)
    {

        $juryMember = JuryMember::find($id);

        if (!$juryMember) {
            return response()->json(['message' => 'Jury not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $juryMember->username = $request->get('username');
        $juryMember->save();

        return response()->json(['message' => 'Jury member updated', 'juryMember' => $juryMember]);
    }

    public function destroy($id)
    {
        $juryMember = JuryMember::find($id);

        if (!$juryMember) {
            return response()->json(['message' => 'Jury member not found'], 404);
        }

        $juryMember->delete();
        return response()->json(['message' => 'Jury member deleted']);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('username', 'password');
        $juryMember = JuryMember::where('username', $credentials['username'])->first();

        if (!$juryMember || $credentials['password'] != $juryMember->password) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = JWTAuth::claims(['juryMember' => $juryMember])->fromUser($juryMember);

        return response()->json(['token' => $token, 'JuryMember' => $juryMember], 200);
    }

    public function exit()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully Exited']);
    }

//    ======================================= NOTE =======================================

    public function note(Request $request, $teamId)
    {
        return JWTAuth::parseToken()->authenticate();
        $team  = Team::find($teamId);

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'note' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $note = new Note();
        $note->value = $request->get('note');
        $note->juryMember()->associate($team);
        $note->juryMember()->associate(auth()->user());

        $note->save();

        return response()->json(['note' => $note, 'juryMember' => auth()->user()->username]);
    }
}
