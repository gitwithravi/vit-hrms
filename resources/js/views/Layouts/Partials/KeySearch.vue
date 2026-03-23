<template>
    <div
        class="fixed inset-0 bg-white opacity-90 z-50 w-full h-full overflow-hidden"
        v-if="showSearch"
    >
        Here goes my search result {{ state.search }}

        <div v-for="result in state.results">
            <router-link :to="{ name: result.url }">
                {{ result.label }}
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "KeySearch",
}
</script>

<script setup>
import { ref, reactive, watch, onMounted } from "vue"
import { useStore } from "vuex"

const store = useStore()

const isLoading = ref(false)
const showSearch = ref(false)
const state = reactive({
    search: "",
    results: [],
})

const searchResult = async () => {
    if (state.search.length < 3) {
        return
    }

    isLoading.value = true
    await store
        .dispatch("dashboard/search/search", { search: state.search })
        .then((response) => {
            isLoading.value = false
            state.results = response
        })
        .catch((e) => {
            isLoading.value = false
        })
}

const debouncedSearch = _.debounce(searchResult, 300)

watch(
    () => state.search,
    (value) => {
        if (value) {
            debouncedSearch()
        }
    }
)

onMounted(() => {
    window.addEventListener("keydown", (event) => {
        if (event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
            return
        }

        if (event.key === "Backspace") {
            state.search = state.search.slice(0, -1)
            return
        }

        if (/^[a-zA-Z0-9]$/.test(event.key)) {
            state.search += event.key
            showSearch.value = true
        }

        if (event.key === "Escape") {
            state.search = ""
            state.results = []
            showSearch.value = false
        }
    })
})
</script>
