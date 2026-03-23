<template>
    <TransitionRoot as="template" :show="visibility">
        <div
            class="fixed inset-0 z-50 max-w-full overflow-y-auto"
            @close="emit('close')"
        >
            <div
                class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0 relative"
                ref="loadingContainer"
            >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    />
                </TransitionChild>

                <span
                    class="hidden sm:inline-block sm:h-screen sm:align-middle"
                    aria-hidden="true"
                    >&#8203;</span
                >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        class="dark:bg-dark-body inline-block w-full transform rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-3/4 sm:max-w-3/4 sm:align-middle"
                    >
                        <div>
                            <h3
                                class="flex items-center justify-between border-b border-gray-200 p-4 text-lg font-medium leading-6 text-gray-900 dark:border-gray-700 dark:text-gray-400"
                            >
                                <div>
                                    <slot name="title"></slot>
                                </div>
                                <i
                                    class="fas fa-times cursor-pointer text-gray-400"
                                    @click="emit('close')"
                                ></i>
                            </h3>
                            <div class="mt-2 px-4" v-if="$slots.description">
                                <p class="text-sm text-gray-500"></p>
                            </div>
                            <div class="p-4">
                                <slot></slot>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </div>
    </TransitionRoot>
</template>

<script>
export default {
    name: "BaseModal",
}
</script>

<script setup>
import { ref, computed, watch, useSlots, onMounted } from "vue"
import { TransitionChild, TransitionRoot } from "@headlessui/vue"
import { useLoading } from "vue-loading-overlay"

const slots = useSlots()

const $loading = useLoading({})

const emit = defineEmits(["close"])

const props = defineProps({
    visibility: {
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

onMounted(() => {
    window.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            emit("close")
        }
    })
})
</script>
