<template>
    <label
        :for="for"
        class="text-label block truncate text-sm font-medium dark:text-gray-400"
    >
        <div class="flex justify-between">
            <slot></slot>
        </div>
    </label>
</template>

<script>
export default {
    name: "BaseLabel",
}
</script>

<script setup>
const props = defineProps({
    for: {
        type: String,
        default: "",
    },
})
</script>
