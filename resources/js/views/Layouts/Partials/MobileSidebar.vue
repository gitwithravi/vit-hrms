<template>
    <TransitionRoot as="template" :show="mobileSidebar">
        <Dialog
            as="div"
            class="fixed inset-0 z-40 flex lg:hidden"
            @close="setMobileSidebar(false)"
        >
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <DialogOverlay
                    class="fixed inset-0 bg-gray-600 bg-opacity-75"
                />
            </TransitionChild>
            <TransitionChild
                as="template"
                enter="transition ease-in-out duration-300 transform"
                enter-from="-translate-x-full"
                enter-to="translate-x-0"
                leave="transition ease-in-out duration-300 transform"
                leave-from="translate-x-0"
                leave-to="-translate-x-full"
            >
                <div
                    class="max-w-64 dark:bg-dark-header relative flex w-full flex-1 flex-col bg-white pb-4 pt-5 dark:text-gray-400"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-in-out duration-300"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="ease-in-out duration-300"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="absolute right-0 top-0 -mr-12 pt-2">
                            <button
                                type="button"
                                class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                @click="setMobileSidebar(false)"
                            >
                                <span class="sr-only">Close sidebar</span>
                                <XMarkIcon
                                    class="h-6 w-6 text-white"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>
                    </TransitionChild>
                    <div class="flex items-center px-4">
                        <img class="h-12 w-auto" :src="getLogo" alt="logo" />
                    </div>
                    <div class="mt-5 h-0 flex-1 overflow-y-auto">
                        <nav>
                            <div class="space-y-1">
                                <AppNavigation mobile></AppNavigation>
                            </div>
                        </nav>
                    </div>
                </div>
            </TransitionChild>
            <div class="w-32" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { computed } from "vue"
import { useStore } from "vuex"
import { getConfig } from "@core/helpers/action"

import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue"

const props = defineProps({
    navigation: {
        type: Array,
        default: [],
    },
})

const store = useStore()

const display = computed(() => store.getters["layout/getDisplay"])
const getLogo =
    display.value == "dark"
        ? getConfig("assets.logoLight")
        : getConfig("assets.logo")
const mobileSidebar = computed(() => store.getters["layout/mobileSidebar"])

const setMobileSidebar = (value) => {
    store.dispatch("layout/setMobileSidebar", value)
}
</script>
