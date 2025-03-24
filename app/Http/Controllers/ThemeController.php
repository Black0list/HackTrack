<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    public function index()
    {
        return response()->json(Theme::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $theme = new Theme();
            $theme->name = $validator['name'];
            $theme->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $theme = Theme::findOrfail($id);

        if(!$theme){
            return response()->json(['error' => 'Theme not found'], 404);
        }

        return response()->json($theme, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $theme = Theme::find($id);

        if (!$theme) {
            return response()->json(['error' => 'Theme not found'], 404);
        }

        try {
            $theme->name = $request->input('name');
            $theme->save();

            return response()->json(['message' => 'Theme updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the theme'], 500);
        }
    }



    public function destroy($id)
    {
        $theme = Theme::find($id);

        if (!$theme) {
            return response()->json(['error' => 'Theme not found'], 404);
        }

        try {
            $theme->delete();
            return response()->json(['message' => 'Theme deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting theme', 'error' => $e->getMessage()], 500);
        }
    }
}
