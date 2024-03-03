<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Tile from '@/Components/Tile.vue';
import Search from '@/Components/Search.vue';
import { ref } from 'vue';

const props = defineProps({
    pokemons: {
        type: Object,
        required: true,
    },
    pokemonNames: {
        type: Object,
        required: true,
    }
});

const pokemonList = ref(props.pokemons)
const searching = ref(false);
const error = ref('')

const onSearchChanged = (value) => {
    searching.value = true;
    axios.get(`/api/pokemons/${value}`)
        .then(response => {
            pokemonList.value = response.data.data
            searching.value = false;
        })
        .catch(error => {
            error.value = error.message
            searching.value = false;
        })
}

const onFilterChanged = (value) => {
    pokemonList.value.sort((a, b)=>{
        if(value === 'ID'){
            return a.id - b.id;
        }

        return a.name.localeCompare(b.name)
    })
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
                <div class="col-lg-6">
                    <Search :pokemons="pokemonNames" @searchChanged="onSearchChanged" @filterChanged="onFilterChanged"/>
                </div>
            </div>

            <Tile v-for="pokemon in pokemonList" :pokemon="pokemon" class="row py-2" v-if="!searching" />
            <div v-if="error">
                {{ error }}
            </div>
            <div v-if="!error && searching"
                class="border-0 rounded px-1 d-flex justify-content-center align-items-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
.suggestion:hover {
    background-color: rgb(196, 196, 196);
    cursor: pointer;
}
</style>
