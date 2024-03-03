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

    public function image()
    {
        return $this->image_url;
    }

    public function information($key = null)
    {

        $response = Http::get($this->url)->json();
        $pokemonInformation = collect($response);
        if ($key === null) {
            return $pokemonInformation;
        }

        return $pokemonInformation->get($key);
    }

    public function typeColor($type)
    {
        $colors = [
            'normal' => "#A8A77A",
            'fire' => "#EE8130",
            'water' => "#6390F0",
            'electric' => "#F7D02C",
            'grass' => "#7AC74C",
            'ice' => "#96D9D6",
            'fighting' => "#C22E28",
            'poison' => "#A33EA1",
            'ground' => "#E2BF65",
            'flying' => "#A98FF3",
            'psychic' => "#F95587",
            'bug' => "#A6B91A",
            'rock' => "#B6A136",
            'ghost' => "#735797",
            'dragon' => "#6F35FC",
            'dark' => "#705746",
            'steel' => "#B7B7CE",
            'fairy' => "#D685AD",
            'stellar' => "#FF4D80"
        ];

        return $colors[$type];

    }

    public function types()
    {
        $types = $this->information('types');
        $typeNames = [];

        foreach ($types as $type) {
            $typeNames[] = [$type['type']['name'], $this->typeColor($type['type']['name'])];
        }

        return $typeNames;
    }
}
