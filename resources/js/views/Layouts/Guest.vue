<template>
    <NotificationBar type="guest" />
    <div
        class="dark:bg-dark-body scroller-thin-y scroller-hidden flex min-h-screen bg-gray-50"
    >
        <div class="blur-xs relative hidden flex-1 md:block">
            <img
                class="absolute inset-0 h-full w-full object-cover"
                src="/images/guest-background.jpeg"
                alt=""
            />
        </div>
        <div class="flex-1 p-4 sm:p-16 lg:flex-none lg:p-32">
            <div class="flex h-full flex-col justify-center">
                <div class="flex justify-center">
                    <a href="/" class="mb-6">
                        <img class="h-16 w-auto" :src="getIcon" alt="" />
                    </a>
                </div>

                <div
                    class="dark:bg-dark-header mx-auto w-full rounded-xl bg-white px-8 py-10 shadow-md sm:w-96"
                >
                    <router-view />
                </div>

                <FooterCredit />
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>

<script setup>
import { getConfig } from "@core/helpers/action"

const getIcon =
    getConfig("layout.display").value == "dark"
        ? getConfig("assets.iconLight")
        : getConfig("assets.icon")
</script>
