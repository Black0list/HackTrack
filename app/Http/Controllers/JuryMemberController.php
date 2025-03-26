<?php

namespace App\Http\Controllers;

use App\Models\Jury;
use App\Models\JuryMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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
            return response()->json('Jury not found', 404);
        }

        $username = 'juryMember_'.$request->get('username');
        $pin = Str::random(15);


        $juryMember = new JuryMember();
        $juryMember->username = $username;
        $juryMember->pin = $pin;
        $juryMember->jury()->associate($jury);

        $juryMember->save();

        return response()->json($juryMember);
    }
}
