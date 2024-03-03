<script setup>
import { onMounted } from 'vue';
import { ref } from 'vue';

const types = ref([])
const loading = ref(true);
const isHovered = ref(false)

const props = defineProps({
    pokemon: {
        type: Object,
        required: true,
    }
});

const getType = async () => {
    axios.get(`/api/pokemons/${props.pokemon.id}/types`)
        .then(response => {
            types.value = response.data.data;
            loading.value = false;
        })
}

onMounted(() => {
    getType()
})
</script>

<template>
    <div class="col-lg-3">
        <!-- TODO: Modal for pokemon -->
        <div class="d-flex justify-content-center align-items-center"
            :style="{ transform: isHovered ? 'scale(1.05)' : 'scale(1)', transition: 'transform 0.3s', cursor: 'pointer' }"
            @mouseenter=" isHovered = true" @mouseleave="isHovered = false">
            <img :src="pokemon.image_url" :alt="pokemon.name" class="bg-light border-0 rounded">
        </div>

        <div>
            <div>
                <span>#{{ String(pokemon.id).padStart(3, '0') }}</span>
            </div>
            <div class="capitalize">{{ pokemon.name }}</div>
            <div class="d-flex gap-2">
                <div v-if="loading" class="border-0 rounded px-1 d-flex justify-content-center align-items-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div v-else v-for="pokemonType in types" class="capitalize px-1 border-0 rounded"
                    :style="{ 'background-color': pokemonType[1] }">
                    {{ pokemonType[0] }}
                </div>
            </div>
        </div>
    </div>

</template>

<style>
.capitalize {
    text-transform: capitalize;
}
</style>
