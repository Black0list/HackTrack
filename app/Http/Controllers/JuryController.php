<?php

namespace App\Http\Controllers;

use App\Models\Jury;
use Illuminate\Http\Request;

class JuryController extends Controller
{
    public function index()
    {
        return response()->json(Jury::all());
    }

    public function store(Request $request)
    {
        $validatedData = validator($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 400);
        }

        $jury = new Jury();
        $jury->name = $request->input('name');
        $jury->save();

        return response()->json(['message' => 'Jury Created','jury' => $jury]);
    }

    public function show($id)
    {
        $jury = Jury::find($id);

        if(!$jury){
            return response()->json(['message' => 'Jury Not Found'], 404);
        }

        return response()->json($jury);
    }

    public function update(Request $request, $id)
    {
        $validatedData = validator($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 400);
        }

        $jury = Jury::find($id);

        if(!$jury){
            return response()->json(['message' => 'Jury Not Found'], 404);
        }

        $jury->name = $request->input('name');
        $jury->save();

        return response()->json(['message' => 'Jury Updated','jury' => $jury]);
    }

    public function destroy($id)
    {
        $jury = Jury::find($id);

        if(!$jury){
            return response()->json(['message' => 'Jury Not Found'], 404);
        }

        $jury->delete();
    }
}
