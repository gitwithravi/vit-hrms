<template>
    <TransitionRoot as="template" :show="visibility">
        <div class="fixed inset-0 z-20 overflow-hidden" @close="emit('close')">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0" />

                <div
                    class="lg:max-w-1/2 max-w-3/4 fixed inset-y-0 right-0 flex pl-16"
                >
                    <TransitionChild
                        as="template"
                        enter="transform transition ease-in-out duration-500 sm:duration-700"
                        enter-from="translate-x-full"
                        enter-to="translate-x-0"
                        leave="transform transition ease-in-out duration-500 sm:duration-700"
                        leave-from="translate-x-0"
                        leave-to="translate-x-full"
                    >
                        <div class="w-screen">
                            <div
                                class="dark:bg-dark-body flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl dark:divide-gray-700"
                            >
                                <div class="h-0 flex-1 overflow-y-auto">
                                    <div
                                        class="bg-primary mt-16 px-4 py-6 dark:bg-black sm:px-6"
                                    >
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div
                                                class="text-lg font-medium text-white"
                                            >
                                                <slot name="title"></slot>
                                            </div>
                                            <div
                                                class="ml-3 flex h-7 items-center"
                                            >
                                                <span
                                                    class="cursor-pointer text-gray-200 hover:text-white"
                                                    @click="emit('close')"
                                                >
                                                    <span class="sr-only"
                                                        >Close panel</span
                                                    >
                                                    <XMarkIcon
                                                        class="h-6 w-6"
                                                        aria-hidden="true"
                                                    />
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="mt-1"
                                            v-if="$slots.description"
                                        >
                                            <p class="text-sm text-indigo-300">
                                                <slot name="description"></slot>
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="scroller-thin-y scroller-hidden flex flex-1 flex-col justify-between overflow-x-hidden p-4"
                                    >
                                        <slot></slot>
                                    </div>
                                </div>
                                <div
                                    class="flex shrink-0 justify-end px-4 py-4"
                                ></div>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </div>
    </TransitionRoot>
</template>

<script setup>
import { ref, useSlots } from "vue"
import { TransitionChild, TransitionRoot } from "@headlessui/vue"
import { XMarkIcon } from "@heroicons/vue/24/outline"

const slots = useSlots()

const emit = defineEmits(["close"])

const props = defineProps({
    visibility: {
        type: Boolean,
        default: false,
    },
})
</script>
