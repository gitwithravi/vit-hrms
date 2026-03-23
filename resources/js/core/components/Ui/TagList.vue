<template>
    <div class="flex flex-wrap">
        <BaseBadge class="ml-2 mt-1" design="primary" v-for="tag in tags">{{
            tag.name
        }}</BaseBadge>
    </div>
</template>

<script>
export default {
    name: "TagList",
}
</script>

<script setup>
const props = defineProps({
    tags: {
        type: Array,
        required: true,
    },
})
</script>
