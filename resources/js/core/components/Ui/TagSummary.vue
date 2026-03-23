<template>
    <div class="space-x-1 space-y-1">
        <BaseBadge
            design="primary"
            v-if="summary.count"
            v-for="tag in summary.tagsDisplay.split(',')"
            >{{ tag }}</BaseBadge
        >
        <BaseBadge design="success" v-if="summary.additionalTagCount > 0">{{
            $trans("global.and_others", {
                attribute: summary.additionalTagCount,
            })
        }}</BaseBadge>
    </div>
</template>

<script>
export default {
    name: "TagSummary",
}
</script>

<script setup>
const props = defineProps({
    summary: {
        type: Object,
        required: true,
    },
})
</script>
