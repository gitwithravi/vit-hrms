<template>
    <p class="text-primary text-4xl font-extrabold sm:text-5xl">{{ type }}</p>
    <div class="sm:ml-6">
        <div class="sm:border-l sm:border-gray-200 sm:pl-6">
            <h1
                class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl"
            >
                {{ title }}
            </h1>
            <p class="mt-1 text-base text-gray-500">{{ description }}</p>
        </div>
        <div
            class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6"
        >
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    type: {
        type: String,
        default: "",
    },
    title: {
        type: String,
        default: "",
    },
    description: {
        type: String,
        default: "",
    },
})
</script>
