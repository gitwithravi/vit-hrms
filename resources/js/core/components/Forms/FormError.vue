<template>
    <div class="text-danger mt-1 text-sm" v-if="error">
        {{ error }}
    </div>
</template>

<script>
export default {
    name: "FormError",
}
</script>

<script setup>
const props = defineProps({
    error: {
        type: String,
        default: "",
    },
})
</script>
