<template>
    <BaseLoader :is-loading="isLoading">
        <div class="mt-4 grid w-full grid-cols-1 gap-3 md:grid-cols-4">
            <template v-for="stat in state.stats">
                <div
                    class="dark:bg-dark-header rounded-lg bg-white px-4 py-2 shadow"
                >
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <h3
                                class="text-base font-normal uppercase text-gray-500"
                            >
                                {{ stat.title }}
                            </h3>
                            <p
                                class="text-2xl font-semibold leading-none text-gray-900 dark:text-gray-400 sm:text-3xl"
                            >
                                {{ stat.count }}
                            </p>
                            <h6
                                class="mt-2 text-xs font-normal uppercase text-gray-700"
                            >
                                {{ stat.secondaryCount }}
                                {{ stat.secondaryTitle }}
                            </h6>
                        </div>
                        <div
                            class="ml-5 flex w-0 flex-1 items-center justify-end font-bold"
                        >
                            <div class="rounded-full" :class="[stat.color]">
                                <i
                                    :class="stat.icon"
                                    class="flex h-12 w-12 items-center justify-center text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </BaseLoader>
</template>

<script>
export default {
    name: "TaskDashboardStat",
}
</script>

<script setup>
import { onMounted, reactive, ref } from "vue"
import { useStore } from "vuex"

const store = useStore()

const isLoading = ref(false)
const state = reactive({
    stats: [],
})

onMounted(async () => {
    isLoading.value = true

    await store
        .dispatch("task/dashboard/getStat")
        .then((response) => {
            isLoading.value = false
            Object.assign(state, {
                stats: response.stats,
            })
        })
        .catch((e) => {
            isLoading.value = false
        })
})
</script>
