<template>
    <Menu as="div" class="relative flex items-center justify-end">
        <MenuButton
            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
            <span class="sr-only">Open options</span>
            <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
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
                class="absolute right-7 top-0 z-10 mx-3 mt-1 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <a
                            href="#"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'group flex items-center px-4 py-2 text-sm',
                            ]"
                        >
                            <PencilSquareIcon
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true"
                            />
                            Edit
                        </a>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <a
                            href="#"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'group flex items-center px-4 py-2 text-sm',
                            ]"
                        >
                            <Square2StackIcon
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true"
                            />
                            Duplicate
                        </a>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <a
                            href="#"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'group flex items-center px-4 py-2 text-sm',
                            ]"
                        >
                            <UserPlusIcon
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true"
                            />
                            Share
                        </a>
                    </MenuItem>
                </div>
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <a
                            href="#"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'group flex items-center px-4 py-2 text-sm',
                            ]"
                        >
                            <TrashIcon
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true"
                            />
                            Delete
                        </a>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
export default {
    name: "RowAction",
}
</script>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue"
import { Bars3Icon } from "@heroicons/vue/20/solid"
import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    Square2StackIcon,
    PencilSquareIcon,
    TrashIcon,
    UserPlusIcon,
} from "@heroicons/vue/20/solid"
</script>
