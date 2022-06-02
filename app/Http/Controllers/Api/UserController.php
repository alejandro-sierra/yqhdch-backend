<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function block(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|integer',
            'status' => 'required|string'
        ]);

        $user = User::find($request->user()->id);
        $recipe = Recipe::find($request->recipe_id);

        if (!$user || !$recipe) {
            return response()->json(['error' => 'Receta o usuario no encontrada'], 404);
        }
        $user->recipes()->attach($recipe, ['status' => $request->status]);
        return response()->json(['message' => 'La receta ' . $recipe->title . ' se a ha añadido a ' . $request->status. ' por el usuario ' .$user->name], 200);

    }
}
