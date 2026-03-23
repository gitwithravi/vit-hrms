<template>
    <Popover class="relative" v-slot="{ open }">
        <PopoverButton
            class="inline-flex focus:outline-none focus:ring-0 ring-0 items-center text-base font-medium text-white"
        >
            <span>
                {{ label }}
            </span>
            <ChevronDownIcon
                :class="['text-white', 'ml-1 h-5 w-5']"
                aria-hidden="true"
            />
        </PopoverButton>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-1 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-1 opacity-0"
        >
            <PopoverPanel
                class="absolute right-0 z-10 mt-3 w-48 max-w-xs transform px-2 sm:px-0"
            >
                <div
                    class="overflow-hidden shadow-lg ring-1 ring-black ring-opacity-5"
                >
                    <div
                        class="relative grid gap-4 bg-white dark:bg-dark-header dark:border dark:border-gray-700 dark:text-gray-400 hover:text-gray-800 hover:dark:text-gray-300 px-5 py-2 sm:gap-4 sm:p-2"
                    >
                        <slot></slot>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>

<script>
export default {
    name: "FlyoutMenu",
}
</script>

<script setup>
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue"
import { ChevronDownIcon } from "@heroicons/vue/20/solid"

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
})
</script>
