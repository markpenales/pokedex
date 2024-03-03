<script setup>
import { onMounted } from 'vue';
import { ref } from 'vue';

const props = defineProps({
    pokemons: {
        type: Object,
        required: true,
    }
})


const search = ref([]);
const searchSuggestions = ref([]);
const suggestionTaken = ref(false);
const filter = ref('ID')
const emits = defineEmits(['searchChanged', 'filterChanged'])


const onClickSuggestion = (suggestion) => {
    search.value = suggestion;
    suggestionTaken.value = true;
}

const onSearchChange = () => {
    if (search.value.length >= 3) {
        searchSuggestions.value = props.pokemons.filter(poke => poke.toLowerCase().includes(search.value.toLowerCase()));
    }
    else {
        searchSuggestions.value = []
    }
}

const onSearch = () => {
    suggestionTaken.value = true;
    emits('searchChanged', search.value);
}

const changeFilter = () => {
    filter.value = filter.value === "ID" ? "Name" : "ID";
    emits('filterChanged', filter.value)
}

</script>

<template>
    <div class="col-lg-6 d-flex gap-2 mb-5 align-items-center" style="z-index: 100;">
        <div class="col-lg-7">
            <input type="text" class="form-control" placeholder="Search" v-model="search" @input="onSearchChange"
                @click="() => { suggestionTaken = false; }">
            <div class="position-absolute col-lg-4 bg-light pt-1" v-if="searchSuggestions.length && !suggestionTaken">
                <div class="border p-2 suggestion" v-for="suggestion in searchSuggestions" :key="suggestion"
                    @click="onClickSuggestion(suggestion)">{{ suggestion }}</div>
            </div>
        </div>
        <button class="btn btn-outline-secondary" @click="onSearch">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>

        <button class="btn btn-outline-secondary" @click="changeFilter">
            <span>
                Sort By: {{ filter }}
            </span>
        </button>
    </div>

</template>
