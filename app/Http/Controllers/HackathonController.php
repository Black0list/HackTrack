<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hackathon;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class HackathonController extends Controller
{

    public function index()
    {
        return response()->json(Hackathon::all());
    }


    public function store(Request $request)
    {
        try {
            $admin = JWTAuth::parseToken()->authenticate(); // or use auth()->user()

            if (!$admin) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }


            $validator = Validator::make($request->all(), [
                'date' => 'required|date_format:Y-m-d',
                'place' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }


            $hackathon = new Hackathon();
            $hackathon->date = $request->date;
            $hackathon->place = $request->place;
            $hackathon->admin = $admin->id;


            $hackathon->save();

            return response()->json($hackathon, 201);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }



    public function show(Hackathon $hackathon)
    {
        return response()->json($hackathon, 200);
    }


    public function update(Request $request, Hackathon $hackathon)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|date_format:Y-m-d',
            'place' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $hackathon->update($request->all());
        return response()->json($hackathon, 200);
    }

    public function delete(Hackathon $hackathon)
    {
        $hackathon->delete();
        return response()->json(['message' => 'Hackathon deleted successfully']);
    }
}
