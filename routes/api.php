<?php

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pokemons/{pokemon}/types', function(Pokemon $pokemon){
    $types = $pokemon->information('types');
    $typeNames = [];

    foreach($types as $type){
        $typeNames[] = $type['type']['name'];
    }

    dd($typeNames);
});
