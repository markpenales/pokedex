<script setup>
import { onMounted } from 'vue';
import { ref } from 'vue';
import { Modal } from 'ant-design-vue';

const types = ref([])
const typeWeaknesses = ref([])
const loading = ref(true);
const isHovered = ref(false)
const error = ref(false);
const errorModal = ref(false);
const isLoadingModal = ref(true);
const visible = ref(false);
const pokemonInformation = ref([]);

const typeColors = {
    normal: '#A8A77A',
    fire: '#EE8130',
    water: '#6390F0',
    electric: '#F7D02C',
    grass: '#7AC74C',
    ice: '#96D9D6',
    fighting: '#C22E28',
    poison: '#A33EA1',
    ground: '#E2BF65',
    flying: '#A98FF3',
    psychic: '#F95587',
    bug: '#A6B91A',
    rock: '#B6A136',
    ghost: '#735797',
    dragon: '#6F35FC',
    dark: '#705746',
    steel: '#B7B7CE',
    fairy: '#D685AD',
}

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
        .catch(error => {
            error.value = true;
        })
}

const getInformation = async () => {
    visible.value = !visible.value
    axios.get(`/api/pokemons/${props.pokemon.id}/information`)
        .then(response => {
            pokemonInformation.value = response.data.data
            getWeakness()
            isLoadingModal.value = false;
        })

        .catch(error => {
            errorModal.value = true;
        })
}

const getWeakness = async () => {
    var typeData = []
    for (const type of types.value) {
        try {
            const response = await axios.get(`https://pokeapi.co/api/v2/type/${type[0]}`);
            typeData = response.data.damage_relations.double_damage_from;
        } catch (error) {
            console.error(`Error fetching data for type ${type[0]}:`, error);
        }
    }

    typeWeaknesses.value = typeData;
}

onMounted(() => {
    getType()
})
</script>

<template>
    <Modal v-model:open="visible" :ok-button-props="{ class: 'd-none' }" :cancel-button-props="{ class: 'd-none' }">
        <div v-if="isLoadingModal" class="border-0 rounded px-1 d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else-if="errorModal" class="alert alert-danger d-flex align-items-center" role="alert">
            <span>Error: {{ errorModal }}</span>
            <button type="button" class="btn-close" aria-label="Close" @click="errorModal = null"></button>
        </div>

        <div v-else class="capitalize">
            <div class="fs-4">
                <span>
                    {{ pokemonInformation.name }} | #{{ String(pokemonInformation.id).padStart(3, '0') }}
                </span>
            </div>

            <div>
                <span>Types</span>
                <div class="d-flex gap-2">
                    <div v-for="pokemonType in types" class="capitalize px-1 border-0 rounded"
                        :style="{ 'background-color': pokemonType[1] }">
                        {{ pokemonType[0] }}
                    </div>
                </div>

            </div>

            <div class="border rounded p-2 text-white mt-2" style="background-color: #31a6d7;">
                <div class="row">
                    <div class="row col-lg-6 align-items-center">
                        <span>Height</span>
                        <span class="text-black">{{ pokemonInformation.height / 10 }}m</span>
                    </div>
                    <div class="row col-lg-6 align-items-center">
                        <span>Weight</span>
                        <span class="text-black">{{ pokemonInformation.weight / 10 }}kg</span>
                    </div>
                    <div class="row col-lg-6 align-items-center">
                        <span>Abilities</span>
                        <span v-for="abilities in pokemonInformation.abilities">
                            <span class="text-black">
                                {{ abilities.ability.name }}
                            </span>
                        </span>
                    </div>
                    <div class="row col-lg-6 align-items-center">
                        <span>Weaknesses</span>
                        <div class="d-flex gap-2">
                            <span v-for="weaknesses in typeWeaknesses"
                                :style="{ 'background-color': typeColors[weaknesses.name] }"
                                class="border-0 rounded px-1">
                                {{ weaknesses.name }}
                            </span>
                        </div>

                    </div>
                </div>

            </div>

            <div class="border rounded p-2 text-white mt-2" style="background-color: orange;">
                <div class="row">
                    <div class="row col-lg-4" v-for="stats in pokemonInformation.stats">
                        <span>{{ stats.stat.name }}</span>
                        <span class="text-black">{{ stats.base_stat }}</span>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
    <div class="col-lg-3">
        <div class="d-flex justify-content-center align-items-center"
            :style="{ transform: isHovered ? 'scale(1.05)' : 'scale(1)', transition: 'transform 0.3s', cursor: 'pointer' }"
            @mouseenter=" isHovered = true" @mouseleave="isHovered = false" @click="getInformation">
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
                <div v-else-if="error" class="alert alert-danger d-flex align-items-center" role="alert">
                    <span>Error: {{ error }}</span>
                    <button type="button" class="btn-close" aria-label="Close" @click="error = null"></button>
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
