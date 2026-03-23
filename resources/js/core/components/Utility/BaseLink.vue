<template>
    <div class="text-sm">
        <a
            v-if="to"
            @click="router.push({ name: to })"
            class="text-primary hover:text-dark-primary cursor-pointer font-medium dark:text-gray-400 dark:focus:text-gray-300"
        >
            <slot></slot>
        </a>
        <a
            v-else-if="route"
            @click="router.push(route)"
            class="text-primary hover:text-dark-primary cursor-pointer font-medium dark:text-gray-400 dark:focus:text-gray-300"
        >
            <slot></slot>
        </a>
        <a
            v-else-if="href"
            :href="href"
            class="text-primary hover:text-dark-primary font-medium dark:text-gray-400 dark:focus:text-gray-300"
        >
            <slot></slot>
        </a>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router"

const router = useRouter()

const props = defineProps({
    href: {
        type: String,
        default: "#",
    },
    to: {
        type: String,
        default: null,
    },
    route: {
        type: Object,
        default: {},
    },
})
</script>
