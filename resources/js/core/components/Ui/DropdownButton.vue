<template>
    <span class="relative z-10 inline-flex rounded-md shadow-sm">
        <span
            v-if="as === 'span'"
            class="dark:bg-dark-header relative inline-flex items-center truncate rounded-l-md border border-r-0 border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-0 dark:border-gray-700 dark:text-gray-400"
        >
            {{ label }}
        </span>
        <button
            type="button"
            v-if="as === 'button'"
            class="dark:bg-dark-header relative inline-flex items-center truncate rounded-l-md border border-r-0 border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-0 dark:border-gray-700 dark:text-gray-400"
        >
            {{ label }}
        </button>
        <Menu as="span" class="relative -ml-px block">
            <MenuButton
                class="dark:bg-dark-header relative inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-0 dark:border-gray-700"
            >
                <span class="sr-only">Open options</span>
                <ChevronUpIcon
                    v-if="direction === 'up'"
                    class="h-5 w-5"
                    aria-hidden="true"
                />
                <ChevronDownIcon
                    v-if="direction === 'down'"
                    class="h-5 w-5"
                    aria-hidden="true"
                />
            </MenuButton>
            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <MenuItems
                    class="dark:bg-dark-header absolute right-0 -mr-1 mt-2 w-56 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                    :class="{
                        'bottom-10 origin-bottom-right': direction === 'up',
                        'origin-top-right': direction === 'down',
                    }"
                >
                    <slot></slot>
                </MenuItems>
            </transition>
        </Menu>
    </span>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue"
import { ChevronUpIcon, ChevronDownIcon } from "@heroicons/vue/20/solid"

const props = defineProps({
    direction: {
        type: String,
        default: "down",
    },
    label: {
        type: String,
        default: "",
    },
    as: {
        type: String,
        default: "span", // span|button
    },
})

const items = [
    { name: "Save and schedule", href: "#" },
    { name: "Save and publish", href: "#" },
    { name: "Export PDF", href: "#" },
]
</script>
