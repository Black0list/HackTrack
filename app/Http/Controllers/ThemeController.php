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

    public function show(Theme $theme)
    {
        return response()->json($theme);
    }

    public function update(Request $request, Theme $theme)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $theme->name = $validator['name'];
            $theme->save();
            return response()->json(['message' => 'Theme updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Theme $theme)
    {
        try {
            $theme->delete();
            return response()->json(['message' => 'Theme deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting theme', 'error' => $e->getMessage()], 500);
        }
    }
}
