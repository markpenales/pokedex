<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = "https://pokeapi.co/api/v2/pokemon?limit=10000";
        $response = Http::get($url);
        $pokemons = $response->json()['results'];

        foreach ($pokemons as $pokemon) {
            $name = $pokemon['name'];
            $url = $pokemon['url'];
            $parts = explode('/', $url);
            $id = str_pad($parts[count($parts) - 2], 3, '0', STR_PAD_LEFT);
            $image_url = "https://assets.pokemon.com/assets/cms2/img/pokedex/full/$id.png";

            Pokemon::query()
                ->firstOrCreate(
                    [
                        'name' => $name
                    ],
                    [
                        'name' => $name,
                        'url' => $url,
                        'image_url' => $image_url
                    ]
                );

        }
    }
}
