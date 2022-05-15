<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function recipes()
    {
        return Recipe::all();
    }
    
    public function recipeRandom()
    {
        // TODO: Revisar como hacer el random
        /*
        $recipe = Recipe::all("id");
        
        $recipeRandom = rand(min($recipe), max($recipe));
        
        $recipe = Recipe::find($recipeRandom);
        */

        $recipe = Recipe::find(1);

        $arrayIngredient = [];

        foreach ($recipe->ingredients as $ingredient) {
            $arrayIngredient[$ingredient->name] = $ingredient->pivot->quantity;
        }
        
        $response = [
            "id" => $recipe->id,
            "title" => $recipe->title,
            "preparation" => $recipe->preparation,
            "difficulty" => $recipe->difficulty,
            "preparation_time" => $recipe->preparation_time,
            "diet" => $recipe->diet,
            "ingredient" => $arrayIngredient
        ];
        
        return $response;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
}
