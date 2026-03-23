<template>
    <MobileSidebar></MobileSidebar>

    <div class="hidden lg:flex lg:shrink-0">
        <div
            @mouseover="sidebarMouseOver"
            @mouseleave="sidebarMouseLeave"
            class="border-primary bg-primary dark:bg-dark-header flex flex-col border-r pb-4 pt-5 transition-all duration-200 ease-out dark:border-gray-700"
            :class="{
                'absolute left-0 top-0 z-40 h-full': !isPinnedSidebar,
                'w-16': isMiniSidebar,
                'w-64': isFullSidebar || isPinnedSidebar,
            }"
        >
            <div
                class="scroller-thin-y scroller-hidden flex h-0 flex-1 flex-col overflow-x-hidden"
            >
                <nav class="mt-6 px-0">
                    <AppNavigation />
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue"
import { useStore } from "vuex"

const store = useStore()

const sidebarType = computed(() => store.getters["layout/getSidebarType"])
const isMiniSidebar = computed(() => sidebarType.value === "mini")
const isFullSidebar = computed(() => sidebarType.value === "full")
const isPinnedSidebar = computed(() => sidebarType.value === "pinned")
const showMenuName = computed(
    () => isFullSidebar.value || isPinnedSidebar.value
)

const sidebarMouseOver = () => {
    if (!isPinnedSidebar.value) {
        store.dispatch("layout/setSidebarType", "full")
    }
}

const sidebarMouseLeave = () => {
    if (!isPinnedSidebar.value) {
        store.dispatch("layout/setSidebarType", "mini")
    }
}
</script>
