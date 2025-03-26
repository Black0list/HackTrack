<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Theme;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Hackathon;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class HackathonController extends Controller
{
    public function index()
    {
        return response()->json(Hackathon::with(['themes', 'rules'])->get());
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date_format:Y-m-d',
                'place' => 'required|string|max:255',
                'themes' => 'required|array',
                'rules' => 'required|array',
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

            $rulesIds = $request['rules'];
            $notFoundRules = [];
            $attachedRules = [];

            foreach ($rulesIds as $id) {
                try {
                    $rule = Rule::findOrFail($id);
                    $hackathon->rules()->attach($rule);
                    $attachedRules[] = $rule;
                } catch (ModelNotFoundException $e) {
                    $notFoundRules[] = $id;
                    continue;
                }
            }

            return response()->json([
                'data' => $hackathon,
                'attached_rules' => $attachedRules,
                'not_found_rules' => $notFoundRules
            ], empty($notFoundRules) ? 200 : 404);


        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }

    public function show($id)
    {
        $hackathon = Hackathon::findOrfail($id);

        if(!$hackathon){
            return response()->json(['error' => 'Hackathon not found'], 404);
        }

        return response()->json($hackathon, 200);
    }


    public function update(Request $request, $id)
    {
        $hackathon = Hackathon::findOrfail($id);

        if(!$hackathon){
            return response()->json(['error' => 'Hackathon not found'], 404);
        }

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

    public function delete($id)
    {
        $hackathon = Hackathon::find($id);

        if(!$hackathon){
            return response()->json(['error' => 'Hackathon not found'], 404);
        }

        $hackathon->delete();
        return response()->json(['message' => 'Hackathon deleted successfully']);
    }
}
