<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    public function index()
    {
        return response()->json(Rule::all());
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
            $rule = new Rule();
            $rule->name = $request['name'];
            $rule->save();

            return response()->json(['message' => 'Rule created'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $rule = Rule::find($id);

        if(!$rule){
            return response()->json(['error' => 'rule not found'], 404);
        }

        return response()->json($rule);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $rule = Rule::find($id);

        if(!$rule){
            return response()->json(['error' => 'rule not found'], 404);
        }

        try {
            $rule->name = $request['name'];
            $rule->save();
            return response()->json(['message' => 'Rule updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $rule = Rule::find($id);

        if(!$rule){
            return response()->json(['error' => 'rule not found'], 404);
        }

        try {
            $rule->delete();
            return response()->json(['message' => 'Rule deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting rule', 'error' => $e->getMessage()], 500);
        }
    }

}
