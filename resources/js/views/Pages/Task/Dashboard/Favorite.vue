<template>
    <BaseFlexCard class="md:w-1/3" :is-loading="isLoading">
        <template #title>
            {{ $trans("general.greeting_message", { name: user }) }}
            <h3 class="text-2xl font-semibold">
                {{ moment().format("dddd Do, MMMM YYYY") }}
            </h3>
        </template>
        <div class="scroller-thin-y scroller-hidden max-h-96">
            <template v-for="favorite in favorites">
                <div
                    class="border-b border-gray-200 p-4 hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-neutral-700"
                >
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <div
                                class="rounded-full p-2"
                                :class="[favorite.color]"
                            >
                                <i
                                    :class="favorite.icon"
                                    class="flex h-6 w-6 items-center justify-center text-white"
                                ></i>
                            </div>
                        </div>
                        <div class="ml-5 flex w-0 flex-1 items-center">
                            <div>
                                <p class="dark:text-gray-400">
                                    {{ favorite.title }}
                                </p>
                                <p class="text-sm dark:text-gray-500">
                                    {{ favorite.date }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div class="px-4" v-if="favorites.length == 0">
                <BaseAlert design="info" size="xs">{{
                    $trans("general.errors.record_not_found")
                }}</BaseAlert>
            </div>
        </div>
    </BaseFlexCard>
</template>

<script>
export default {
    name: "TaskDashboardFavorite",
}
</script>

<script setup>
import { onMounted, inject, reactive, ref } from "vue"
import { useStore } from "vuex"
import { getAuthUser } from "@core/helpers/action"

const store = useStore()

const moment = inject("moment")

const user = getAuthUser("profile.name")

const isLoading = ref(false)
const favorites = reactive([])

onMounted(async () => {
    isLoading.value = true

    await store
        .dispatch("task/dashboard/getFavorite")
        .then((response) => {
            isLoading.value = false
            Object.assign(favorites, response)
        })
        .catch((e) => {
            isLoading.value = false
        })
})
</script>
