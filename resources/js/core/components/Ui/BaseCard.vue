<template>
    <div
        class="relative space-y-3 lg:col-span-9 lg:px-0"
        :class="{
            '': !noContentPadding,
        }"
        ref="loadingContainer"
    >
        <div class="relative" :class="{}">
            <!-- 'shadow sm:rounded-md sm:overflow-hidden': ! noBorder -->
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
            <div
                class="dark:bg-dark-header bg-white"
                :class="{
                    'px-2 sm:p-2': lessPadding,
                    'px-4 sm:p-6': !lessPadding && !noPadding,
                    'py-6': !noContentPadding,
                    'pb-6': bottomContentPadding,
                    'pt-6': topContentPadding,
                    'sm:rounded-tl-lg sm:rounded-tr-lg':
                        !$slots.title && !$slots.action,
                    'sm:rounded-bl-lg sm:rounded-br-lg':
                        !$slots.footer && !$slots.progress,
                }"
            >
                <slot></slot>
            </div>
            <div
                v-if="$slots.footer"
                class="dark:bg-dark-header bg-white px-4 py-3 text-right sm:rounded-bl-lg sm:rounded-br-lg sm:px-6"
            >
                <slot name="footer"></slot>
            </div>
            <div
                v-if="$slots.progress"
                class="dark:bg-dark-header bg-white text-right sm:rounded-bl-lg sm:rounded-br-lg"
            >
                <slot name="progress"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BaseCard",
}
</script>

<script setup>
import { useSlots, ref, computed, watch } from "vue"
import { useLoading } from "vue-loading-overlay"

const slots = useSlots()

const $loading = useLoading({})

const props = defineProps({
    noBorder: {
        type: Boolean,
        default: false,
    },
    lessPadding: {
        type: Boolean,
        default: false,
    },
    noPadding: {
        type: Boolean,
        default: false,
    },
    noContentPadding: {
        type: Boolean,
        default: false,
    },
    bottomContentPadding: {
        type: Boolean,
        default: false,
    },
    topContentPadding: {
        type: Boolean,
        default: false,
    },
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
