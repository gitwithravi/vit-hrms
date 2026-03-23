<template>
    <nav class="md:space-y-3 flex flex-wrap md:inline-block">
        <router-link
            v-for="navigation in navigations"
            :key="navigation.name"
            :to="getPath(navigation)"
            class="hover:text-darken-secondary group flex items-center px-3 py-2 text-sm font-medium w-1/3 md:w-full"
            :class="{
                'text-darken-secondary': route.name === navigation.name,
                'text-light-secondary': route.name !== navigation.name,
            }"
            :aria-current="route.name === navigation.name ? 'page' : undefined"
        >
            <span
                class="ml-2 mr-3 w-6 shrink-0"
                :class="[navigation.icon]"
                aria-hidden="true"
            />
            <span class="truncate">
                {{ $trans(navigation.label) }}
            </span>
        </router-link>
    </nav>
</template>

<script>
export default {
    name: "ModuleConfigSidebar",
}
</script>

<script setup>
import { inject } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()

const $trans = inject("$trans")

const props = defineProps({
    navigations: {
        type: Array,
        default: [],
    },
    useUuid: {
        type: Boolean,
        default: false,
    },
})

const getPath = (navigation) => {
    if (props.useUuid && route.params.uuid) {
        return {
            name: navigation.name,
            params: { uuid: route.params.uuid },
        }
    }

    return { name: navigation.name }
}
</script>
