<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\Hackathon;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class HackathonController extends Controller
{

    public function index()
    {
        return response()->json(Hackathon::all());
    }

    public function store(Request $request)
    {
        try {
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

            $hackathon->save();

            $themes = $request['themes'];
            foreach ($themes as $themed) {
                $theme = new Theme();
                $theme->name = $themed;
                $theme->hackathon()->associate($hackathon);
                $theme->save();
            }

            $rules = $request['rules'];
            foreach ($rules as $ruled) {
                $rule = new Rule();
                $rule->name = $ruled;
                $rule->hackathon()->associate($hackathon);
                $rule->save();
            }

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
