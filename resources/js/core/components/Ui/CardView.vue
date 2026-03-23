<template>
    <div
        class="dark:bg-dark-header relative overflow-hidden rounded-lg border border-gray-300 bg-white shadow-lg focus-within:ring-2 focus-within:ring-offset-2 hover:border-gray-400 dark:border-gray-600"
    >
        <div class="flex items-center space-x-3 px-4 py-3">
            <div
                class="flex-shrink-0"
                :class="{
                    'cursor-pointer': path.name,
                }"
                v-if="imgSrc"
                @click="navigateTo()"
            >
                <img class="h-16 w-16 rounded-full" :src="imgSrc" alt="" />
            </div>
            <div class="min-w-0 flex-1">
                <div class="space-y-1 focus:outline-none">
                    <!-- <span class="absolute inset-0" aria-hidden="true" /> -->
                    <div class="flex items-start justify-between">
                        <p
                            class="text-sm font-medium text-gray-900 dark:text-gray-400"
                            :class="{
                                'cursor-pointer': path.name,
                            }"
                            @click="navigateTo()"
                        >
                            <slot name="title"></slot>
                        </p>

                        <div class="absolute right-2 top-2">
                            <slot name="action"></slot>
                        </div>
                    </div>
                    <slot></slot>
                </div>
            </div>
        </div>
        <div>
            <slot name="progress"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "CardView",
}
</script>

<script setup>
import { useRouter } from "vue-router"

const router = useRouter()

const props = defineProps({
    imgSrc: {
        type: String,
        default: "",
    },
    path: {
        type: Object,
        default() {
            return {}
        },
    },
})

const navigateTo = () => {
    if (!props.path) {
        return
    }

    router.push(props.path)
}
</script>
