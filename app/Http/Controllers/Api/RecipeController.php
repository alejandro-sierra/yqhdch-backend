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

    public function recipe($number, $time, $difficulty, $diet)
    {
        // FIXME: cambiar cuando tenga más recetas <= de preparation_time por un =
        $query = Recipe::inRandomOrder()->where("preparation_time", "<=", $time)
            ->where("difficulty", "=", $difficulty)->where("diet", "=", $diet)->limit($number)->get();

        $arrayIngredient = [];

        if (count($query)) {
            foreach ($query as $recipe) {
                foreach ($recipe->ingredients as $ingredient) {
                    $arrayIngredient[] = $ingredient->name . " " . $ingredient->pivot->quantity;
                    // $arrayIngredient[$ingredient->name] = $ingredient->pivot->quantity;
                }
                $response[] = [
                    "id" => $recipe->id,
                    "title" => $recipe->title,
                    "preparation" => $recipe->preparation,
                    "difficulty" => $recipe->difficulty,
                    "preparation_time" => $recipe->preparation_time,
                    "diet" => $recipe->diet,
                    "url_image" => $recipe->url_image,
                    "ingredients" => $arrayIngredient
                ];
            }
            return $response;
        } else {
            return response()->json(["error" => "No hemos podido encontrado una recetas con tus especificaciones."], 202);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'preparation' => 'required|string',
            'difficulty' => 'required|string',
            'preparation_time' => 'required|integer',
            'diet' => 'required|string',
            'url_image' => 'required|string',
        ]);

        $recipe = new Recipe();

        $recipe->title = $request->title;
        $recipe->preparation = $request->preparation;
        $recipe->difficulty = $request->difficulty;
        $recipe->preparation_time = $request->preparation_time;
        $recipe->diet = $request->diet;
        $recipe->url_image = $request->url_image;

        $recipe->save();

        $response = [
            'recipe' => $recipe,
        ];

        // FIXME: Se puede añadir la receta, ahora hay que añadir los incredientes y relacionarlos

        return response($recipe, 201);
    }


    public function delete($id)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            return response()->json(['error' => 'Receta no encontrada'], 404);
        } else {
            $recipe->delete();
            return response()->json(['content' => 'Chollo eliminado correctamente'], 200);
        }
    }

    public function getPreparationTimes()
    {
        $arrayTimes = [];

        $times = Recipe::distinct()->get(['preparation_time']);
        foreach ($times as $time) {
            $arrayTimes[] = $time->preparation_time;
        }
        if (!$times) {
            return response()->json(['error' => 'Receta no encontrada'], 404);
        }
        return response($arrayTimes, 200);
    }

    public function getDiets()
    {
        $arrayDiets = [];

        $diets = Recipe::distinct()->get(['diet']);
        foreach ($diets as $diet) {
            $arrayDiets[] = $diet->diet;
        }
        if (!$diets) {
            return response()->json(['error' => 'Receta no encontrada'], 404);
        }
        return response($arrayDiets, 200);
    }

    public function getDifficulties()
    {
        $arrayDifficulties = [];

        $difficulties = Recipe::distinct()->get(['difficulty']);
        foreach ($difficulties as $difficulty) {
            $arrayDifficulties[] = $difficulty->difficulty;
        }
        if (!$difficulties) {
            return response()->json(['error' => 'Receta no encontrada'], 404);
        }
        return response($arrayDifficulties, 200);
    }

    public function getById($id)
    {
        $arrayIngredient = [];
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['error' => 'Receta no encontrada'], 404);
        }
        foreach ($recipe->ingredients as $ingredient) {
            $arrayIngredient[] = $ingredient->name . " " . $ingredient->pivot->quantity;
        }

        $response = [
            "id" => $recipe->id,
            "title" => $recipe->title,
            "preparation" => $recipe->preparation,
            "difficulty" => $recipe->difficulty,
            "preparation_time" => $recipe->preparation_time,
            "diet" => $recipe->diet,
            "url_image" => $recipe->url_image,
            "ingredients" => $arrayIngredient
        ];
        return response($response, 200);
    }
}
// [
//     {
//         "tile": "Ponche segoviano",
//         "preparation": "Comenzaremos el día anterior preparando el mazapán. Para ello mezclamos la harina de almendra, el azúcar y el azúcar invertido, removemos. Añadimos el agua y mezclamos hasta que adquiera una textura manejable. Envolvemos en papel film y dejamos reposar 12 horas en la nevera. Para el bizcocho, precalentamos el horno a 180º y forramos una bandeja con papel de horno. En un bol, batimos las yemas y la mitad del azúcar con unas varillas eléctricas durante unos 10 minutos o hasta que la mezcla blanquee y triplique su volumen. Añadimos las harinas tamizadas y la por último la leche, removemos hasta que no queden grumos. Por otra parte, y también con unas varillas batimos las claras hasta formar un merengue con el resto del azúcar, mezclamos a la mezcla anterior suavemente con movimientos envolventes. Pasamos la mezcla a la bandeja de horno y extendemos para igualar por todos lados. Horneamos unos 12 minutos y cuando esté listo dejamos enfriar. Después cortamos los bordes para igualar el bizcocho y lo cortamos en tres partes iguales. Reservamos hasta el montaje. Para el almíbar, mezclamos el agua y el azúcar hasta que llegue a hervir. Reservamos hasta que enfríe. Para la yema pastelera. En un bol mezclamos el azúcar con la Maicena. Añadimos los huevos bien batidos colándolos por un colador, y hacemos con esto una papilla. Ponemos un cazo al fuego con el agua, cuando esta llegue a 40 grados centígrados, añadimos la papilla anterior al agua caliente y sin dejar de remover con unas varillas cocinamos hasta que espese, unos 7 minutos más o menos. Retiramos del fuego, y tapamos a piel con un fim de cocina . Reservamos hasta que enfríe. ",
//         "difficulty": "media",
//         "preparation_time": 120,
//         "diet": "vegetariano"
//         "url_image": "https://i.blogs.es/0c138a/ponche-segoviano0/1366_2000.jpg"
//     }
// ]