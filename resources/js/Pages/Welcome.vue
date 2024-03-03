<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Tile from '@/Components/Tile.vue';
import { ref } from 'vue';

defineProps({
    pokemons: {
        type: Object,
        required: true,
    },
    pokemonNames: {
        type: Object,
        required: true,
    }
});



const search = ref([]);
const searchSuggestions = ref([]);

const updateSuggestions = () => {
    // TODO
}



</script>

<template>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <Head title="Pokédex" />

    <div class="row d-flex justify-content-center mt-5">
        <div class="col-lg-10 row">
            <div class="row">
                <div class="fs-2 col-lg-2">
                    Pokédex
                </div>

                <div class="col-lg-6 d-flex gap-2 mb-5">
                    <div class="col-lg-8">
                        <input type="text" class="form-control" placeholder="Search" v-model="search">
                        <div class="position-absolute col-lg-4 bg-light pt-1">
                            <div class="border p-2 suggestion" v-for="suggestions in searchSuggestions">sample</div>
                        </div>
                    </div>
                    <button class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <Tile v-for="pokemon in pokemons" :pokemon="pokemon" class="row py-2" />
        </div>
    </div>

</template>

<style>
.suggestion:hover {
    background-color: rgb(196, 196, 196);
    cursor: pointer;
}
</style>
