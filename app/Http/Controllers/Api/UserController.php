<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function status(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|integer',
            'status' => 'required|string'
        ]);

        $user = User::find($request->user()->id);
        $recipe = Recipe::find($request->recipe_id);

        if (!$user || !$recipe) {
            return response()->json(['error' => 'Receta o usuario no encontrada'], 404);
        } else {
            $user_recipe = $user->recipes()->where('recipe_id', $request->recipe_id)->where('status', $request->status)->exists();

            if ($user_recipe) {
                $user->recipes()->detach($recipe, ['status' => $request->status]);
                return response()->json(['message' => 'La receta se a ha quitado de ' . $request->status], 200);
            }

            $user->recipes()->attach($recipe, ['status' => $request->status]);
            return response()->json(['message' => 'La receta se a ha añadido a ' . $request->status], 200);
        }
    }

    public function statusBlock(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['error' => 'Receta o usuario no encontrada'], 404);
        } else {
            $user_recipe = $user->recipes()->where('status', 'bloqueados')->get();
            return response($user_recipe, 200);
        }
    }

    public function statusFavorite(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['error' => 'Receta o usuario no encontrada'], 404);
        } else {
            $user_recipe = $user->recipes()->where('status', 'favoritas')->get();
            return response($user_recipe, 200);
        }
    }
}

// $user_recipe = $user->recipes()->get();