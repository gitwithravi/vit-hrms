<template>
    <div
        class="mt-1 text-xs flex"
        :class="{
            'cursor-pointer': cursor,
            'justify-end': textRight,
        }"
    >
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "HelperText",
}
</script>

<script setup>
const props = defineProps({
    cursor: {
        type: Boolean,
        default: false,
    },
    textRight: {
        type: Boolean,
        default: false,
    },
})
</script>
