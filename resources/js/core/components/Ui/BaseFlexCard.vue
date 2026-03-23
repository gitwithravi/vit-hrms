<template>
    <div
        class="relative w-full bg-white dark:bg-dark-header rounded-lg"
        ref="loadingContainer"
    >
        <div
            v-if="$slots.title || $slots.action"
            class="dark:bg-dark-header flex justify-between border-b border-gray-200 bg-white px-4 py-2 dark:border-gray-700 sm:rounded-tl-lg sm:rounded-tr-lg"
        >
            <div
                v-if="$slots.title"
                class="text-base font-semibold leading-7 text-gray-800 dark:text-gray-400 sm:truncate sm:text-lg"
            >
                <slot name="title"></slot>
            </div>
            <div v-if="$slots.action" class="flex items-center text-right">
                <slot name="action"></slot>
            </div>
        </div>

        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "BaseFlexCard",
}
</script>

<script setup>
import { useSlots, ref, computed, watch } from "vue"
import { useLoading } from "vue-loading-overlay"

const slots = useSlots()

const $loading = useLoading({})

const props = defineProps({
    isLoading: {
        type: Boolean,
        default: false,
    },
})

const loadingContainer = ref(false)
let loader = null

const isLoading = computed(() => {
    return props.isLoading
})

watch(isLoading, (value, prevvalue) => {
    if (value) {
        loader = $loading.show({ container: loadingContainer.value })
    } else if (loader) {
        loader.hide()
    }
})
</script>
