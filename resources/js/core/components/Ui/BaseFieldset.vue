<template>
    <fieldset
        class="rounded-md border border-solid border-gray-300 p-3 dark:border-gray-700"
    >
        <legend
            class="rounded border border-gray-300 p-2 text-sm font-semibold text-gray-800 dark:border-gray-700 dark:text-gray-300"
        >
            <slot name="legend"></slot>
        </legend>
        <slot></slot>
    </fieldset>
</template>

<script>
export default {
    name: "BaseFieldset",
}
</script>

<script setup>
const props = defineProps({})
</script>
