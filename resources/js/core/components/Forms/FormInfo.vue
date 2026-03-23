<template>
    <div class="text-primary mt-1 text-xs" :id="id">
        <slot></slot>
    </div>
</template>

<script setup>
const props = defineProps({
    id: {
        type: String,
        required: false,
    },
})
</script>
