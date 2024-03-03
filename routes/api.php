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

Route::get('/pokemons/{pokemon}/types', function (Pokemon $pokemon) {
    return response()->json(['data' => $pokemon->types()]);
});
Route::get('/pokemons', function (Request $request) {
    $pokemons = Pokemon::all();

    return response()->json(['data' => $pokemons]);
});
Route::get('/pokemons/{pokemon}', function ($pokemon) {
    $pokemons = Pokemon::where('name', 'LIKE', "%$pokemon%")
        ->orWhere('id', $pokemon)
        ->get();

    return response()->json(['data' => $pokemons]);
});
