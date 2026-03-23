<template>
    <NotificationBar type="app" />
    <div
        class="dark:bg-dark-body relative flex h-screen overflow-hidden bg-gray-200"
    >
        <AppSidebar></AppSidebar>

        <div
            class="flex w-0 flex-1 flex-col overflow-hidden"
            :class="{
                'lg:ml-16': !isPinnedSidebar,
            }"
        >
            <AppHeader></AppHeader>

            <main
                class="scroller-thin-y scroller-hidden relative z-0 flex-1 focus:outline-none"
                :class="{
                    'overflow-y-auto': route.query.view != 'board',
                    'overflow-y-hidden': route.query.view == 'board',
                }"
            >
                <div
                    class="space-y-4"
                    :class="{
                        'py-4 lg:px-4': noPadding,
                    }"
                >
                    <router-view />
                </div>

                <FooterCredit />
            </main>
        </div>

        <div
            class="h-screen flex-0 w-1/3 bg-white dark:bg-dark-header"
            v-if="!screenSize.small && showSetupWizard && actingAs('admin')"
        >
            <div
                class="scroller-thin-y scroller-hidden h-screen overflow-x-hidden"
            >
                <SetupWizard />
            </div>
        </div>
    </div>

    <ReLogin />
    <!-- <KeySearch /> -->
</template>

<script setup>
import { computed } from "vue"
import { useStore } from "vuex"
import { useRoute } from "vue-router"
import { actingAs, getConfig, getAuthUser } from "@core/helpers/action"
import { listenPrivate } from "@core/helpers/notification"
import { useScreenSize } from "@core/composables/useScreenSize"

import SetupWizard from "@views/Layouts/Partials/SetupWizard.vue"
import AppSidebar from "@views/Layouts/Partials/AppSidebar.vue"
import AppHeader from "@views/Layouts/Partials/AppHeader.vue"

const store = useStore()
const route = useRoute()

const showSetupWizard = getConfig("system.showSetupWizard")

const isPinnedSidebar = computed(() =>
    store.getters["layout/getSidebarType"] === "pinned" ? true : false
)
const noPadding = computed(() => {
    if (route.meta.noPadding) {
        return false
    }

    return true
})

const getAuthUuid = getAuthUser("uuid")
listenPrivate(`users.${getAuthUuid.value}`, "test.event", (e) => {
    var audio = new Audio("/notification.mp3")
    audio.play()
})

const { screenSize } = useScreenSize()
</script>
