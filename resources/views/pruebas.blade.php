<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pruebas</title>
</head>
<body>
    <h1>Pruebas</h1>

    <h2>Recipe</h2>
    <p>{{$recipe}}</p>
    <br><br> 

    <h2>Recipe - User</h2>
    {{$recipe->users}}
    <br><br> 

    <h2>Recipe - Comment</h2>
    {{$recipe->comments}}
    <br><br> 

    <h2>Recipe - Ingredients</h2>
    @foreach ($recipe->ingredients as $ingredient)
    <p>{{$ingredient->name}}: {{$ingredient->pivot->quantity}}</p><br>
    @endforeach

    <h2>Followers</h2>
    {{$user->followers}}
    {{$user->follows}}
    <br><br> 
  
</body>
</html>