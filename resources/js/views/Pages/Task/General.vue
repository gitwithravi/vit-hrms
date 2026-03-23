<template>
    <BaseCard>
        <div class="dark:text-gray-400" v-html="nl2br(task.description)"></div>
    </BaseCard>
</template>

<script>
export default {
    name: "TaskGeneral",
}
</script>

<script setup>
import { nl2br } from "@core/helpers/string"

const props = defineProps({
    task: {
        type: Object,
        default() {
            return {}
        },
    },
})
</script>
