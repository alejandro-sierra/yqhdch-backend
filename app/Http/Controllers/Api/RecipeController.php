<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use RoachPHP\Shell\Repl;

class RecipeController extends Controller
{
    public function recipes()
    {
        return Recipe::all();
    }
    
    public function recipe()
    {
        // TODO: Revisar como hacer el random
        /*
        $recipe = Recipe::all("id");
        
        $recipeRandom = rand(min($recipe), max($recipe));
        
        $recipe = Recipe::find($recipeRandom);

        public function random()
        {
            return Chollo::inRandomOrder()->limit(1)->get();
        }
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
    
    public function create(Request $request)
    {
        $request -> validate([
            'title' => 'required|string',
            'preparation' => 'required|string',
            'difficulty' => 'required|string',
            'preparation_time' => 'required|integer',
            'diet' => 'required|string',
        ]);

        $recipe = new Recipe();

        $recipe->title = $request->title;
        $recipe->preparation = $request->preparation;
        $recipe->difficulty = $request->difficulty;
        $recipe->preparation_time = $request->preparation_time;
        $recipe->diet = $request->diet;
        
        $recipe->save();

        $response = [
            'recipe' => $recipe,
        ];

        return response($recipe, 201);
    }


    public function delete($id)
    {
        $recipe = Recipe::find($id);
        if(!$recipe){
            return response()->json(['error' => 'Receta no encontrado'], 404);
        }else{
            $recipe -> delete();
            return response()->json(['content' => 'Chollo eliminado correctamente'], 200);
        }
    }
}


// [
//     {
//         "tile": "Ponche segoviano, receta de uno de los pasteles tradicionales más suaves y delicados ",
//         "preparation": "Comenzaremos el día anterior preparando el mazapán. Para ello mezclamos la harina de almendra, el azúcar y el azúcar invertido, removemos. Añadimos el agua y mezclamos hasta que adquiera una textura manejable. Envolvemos en papel film y dejamos reposar 12 horas en la nevera. Para el bizcocho, precalentamos el horno a 180º y forramos una bandeja con papel de horno. En un bol, batimos las yemas y la mitad del azúcar con unas varillas eléctricas durante unos 10 minutos o hasta que la mezcla blanquee y triplique su volumen. Añadimos las harinas tamizadas y la por último la leche, removemos hasta que no queden grumos. Por otra parte, y también con unas varillas batimos las claras hasta formar un merengue con el resto del azúcar, mezclamos a la mezcla anterior suavemente con movimientos envolventes. Pasamos la mezcla a la bandeja de horno y extendemos para igualar por todos lados. Horneamos unos 12 minutos y cuando esté listo dejamos enfriar. Después cortamos los bordes para igualar el bizcocho y lo cortamos en tres partes iguales. Reservamos hasta el montaje. Para el almíbar, mezclamos el agua y el azúcar hasta que llegue a hervir. Reservamos hasta que enfríe. Para la yema pastelera. En un bol mezclamos el azúcar con la Maicena. Añadimos los huevos bien batidos colándolos por un colador, y hacemos con esto una papilla. Ponemos un cazo al fuego con el agua, cuando esta llegue a 40 grados centígrados, añadimos la papilla anterior al agua caliente y sin dejar de remover con unas varillas cocinamos hasta que espese, unos 7 minutos más o menos. Retiramos del fuego, y tapamos a piel con un fim de cocina . Reservamos hasta que enfríe. ",
//         "difficulty": "media",
//         "preparation_time": 120,
//         "diet": "vegetariano"
//     }
// ]