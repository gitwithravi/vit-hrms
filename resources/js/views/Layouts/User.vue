<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('user.user'), path: 'User' }]"
    />
    <ParentTransition appear :visibility="true">
        <article>
            <div class="overflow-hidden rounded-t-lg bg-black">
                <div>
                    <img
                        class="h-32 w-full object-cover lg:h-48"
                        src="/images/user-cover.jpeg"
                        alt=""
                    />
                </div>
                <div class="mx-auto max-w-full px-4 pb-4 sm:px-6 lg:px-8">
                    <div
                        class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5"
                    >
                        <div class="flex items-center space-x-4">
                            <img
                                class="h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32"
                                :src="getAvatar"
                                alt=""
                            />
                            <div class="mt-16">
                                <h1
                                    class="text-secondary truncate text-2xl font-bold"
                                >
                                    {{ getName }}
                                </h1>
                                <span class="text-md text-light-secondary">{{
                                    getEmail
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-black pt-6 sm:pt-2 2xl:pt-5">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <nav class="-mb-px flex flex-wrap" aria-label="Tabs">
                            <router-link
                                v-for="tab in tabs"
                                :key="tab.name"
                                :to="{ name: tab.path }"
                                :class="[
                                    route.name === tab.path
                                        ? 'dark:bg-dark-header rounded-t-lg bg-white text-black dark:border dark:border-b-0 dark:border-gray-700 dark:text-gray-400'
                                        : 'hover:text-secondary border-transparent text-white hover:border-gray-300 dark:text-gray-400 dark:hover:border-gray-700 dark:hover:text-gray-500',
                                    'whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-500',
                                ]"
                                :aria-current="tab.current ? 'page' : undefined"
                            >
                                {{ tab.name }}
                            </router-link>
                        </nav>
                    </div>
                </div>
            </div>

            <div
                class="dark:bg-dark-header flex bg-white sm:rounded-bl-lg sm:rounded-br-lg"
            >
                <div
                    class="mx-auto hidden w-1/3 border-r border-gray-200 px-4 py-6 dark:border-gray-700 sm:px-6 md:block lg:px-8"
                >
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ $trans("user.profile.props.name") }}
                            </dt>
                            <dd
                                class="mt-1 truncate text-sm text-gray-900 dark:text-gray-400"
                            >
                                {{ getName }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ $trans("user.profile.props.email") }}
                            </dt>
                            <dd
                                class="mt-1 truncate text-sm text-gray-900 dark:text-gray-400"
                            >
                                {{ getEmail }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ $trans("user.profile.props.username") }}
                            </dt>
                            <dd
                                class="mt-1 truncate text-sm text-gray-900 dark:text-gray-400"
                            >
                                {{ getUsername }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="mx-auto w-full px-4 py-6 sm:px-6 md:w-2/3 lg:px-8">
                    <router-view />
                </div>
            </div>
        </article>
    </ParentTransition>
</template>

<script>
export default {}
</script>

<script setup>
import { inject, computed } from "vue"
import { useRoute } from "vue-router"
import { useStore } from "vuex"
import { EnvelopeIcon, PhoneIcon } from "@heroicons/vue/20/solid"

const route = useRoute()
const store = useStore()

const getAvatar = computed(() => store.getters["auth/user/user"]("avatar"))
const getName = computed(() => store.getters["auth/user/user"]("profile.name"))
const getEmail = computed(() => store.getters["auth/user/user"]("email"))
const getUsername = computed(() => store.getters["auth/user/user"]("username"))

const $trans = inject("$trans")

const tabs = [
    { name: $trans("user.profile.profile"), path: "UserProfile" },
    { name: $trans("user.profile.account"), path: "UserAccount" },
    { name: $trans("user.avatar"), path: "UserAvatar" },
    { name: $trans("user.preference.preference"), path: "UserPreference" },
    { name: $trans("auth.password.change_password"), path: "UserPassword" },
]
</script>
