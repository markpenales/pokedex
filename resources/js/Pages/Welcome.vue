<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Tile from '@/Components/Tile.vue';

defineProps({
    pokemons: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <Head title="Pokédex" />

    <div v-for="pokemon in pokemons">
        <Tile :pokemon="pokemon"/>
    </div>
</template>
