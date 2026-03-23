<template>
    <span
        class="text-xs text-gray-600 dark:text-gray-400"
        :class="{
            block: block,
            '!text-gray-200': black,
        }"
    >
        <slot></slot>
    </span>
</template>

<script>
export default {
    name: "TextMuted",
}
</script>

<script setup>
const props = defineProps({
    block: {
        type: Boolean,
        default: false,
    },
    black: {
        type: Boolean,
        default: false,
    },
})
</script>
