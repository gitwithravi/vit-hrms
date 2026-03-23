<template>
    <Menu as="div" class="relative flex items-center justify-end">
        <MenuButton
            class="dark:bg-dark-header inline-flex items-center justify-center rounded-full bg-transparent text-gray-400 hover:text-gray-500"
            :class="{
                'h-5 w-5': slim,
                'h-8': !slim,
                'w-8': !noWidth,
            }"
        >
            <span class="sr-only">Open options</span>
            <slot name="clickable">
                <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
            </slot>
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
                class="dark:bg-dark-header absolute z-20 mx-3 mt-1 w-48 origin-top-right divide-y divide-gray-200 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:divide-gray-600 dark:border dark:border-gray-700"
                :class="{
                    'top-0': !topMargin && !doubleTopMargin,
                    'top-6': topMargin,
                    'top-10': doubleTopMargin,
                    'right-7': direction == 'right' && rightMargin,
                    'right-0': direction == 'right' && !rightMargin,
                    'left-0': direction == 'left',
                }"
            >
                <slot></slot>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
export default {
    name: "DropdownMenu",
}
</script>

<script setup>
import { Menu, MenuButton, MenuItems } from "@headlessui/vue"
import { Bars3Icon } from "@heroicons/vue/20/solid"

const props = defineProps({
    slim: {
        type: Boolean,
        default: false,
    },
    noWidth: {
        type: Boolean,
        default: false,
    },
    topMargin: {
        type: Boolean,
        default: false,
    },
    doubleTopMargin: {
        type: Boolean,
        default: false,
    },
    rightMargin: {
        type: Boolean,
        default: true,
    },
    direction: {
        type: String,
        default: "right",
    },
})
</script>
