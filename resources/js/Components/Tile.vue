<script setup>
defineProps({
    pokemon: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <div>
        <img :src="pokemon.image_url" :alt="pokemon.name">
    </div>

    <div>
        <div>
            <span>#{{ String(pokemon.id).padStart(3, '0') }}</span>
        </div>
        <div class="pokemon-name">{{ pokemon.name }}</div>
    </div>
</template>
<style>
.pokemon-name{
    text-transform: capitalize;
}
</style>