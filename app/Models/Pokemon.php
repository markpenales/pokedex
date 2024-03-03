<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = "pokemons";

    protected $fillable = [
        'name',
        'url',
        'image_url',
    ];

    public function image(){
        return $this->image_url;
    }

    public function information($key){

        $response = Http::get($this->url)->json();
        $pokemonInformation = collect($response);
        
        return $pokemonInformation->get($key);
    }

    public function type(){
        $response = Http::get($this->url)->json();
        $type = collect($response)->get('types'); // TODO
    }
}
