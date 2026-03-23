<template>
    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4">
        <dt class="text-sm font-medium text-gray-500" v-if="label">
            {{ label }}
        </dt>
        <dd
            class="mt-1 text-sm text-gray-900 dark:text-gray-400 sm:col-span-2 sm:mt-0"
            :class="{
                'text-right': align == 'right',
                truncate: truncate,
            }"
        >
            <slot></slot>
        </dd>
    </div>
</template>

<script>
export default {
    name: "ListItemView",
}
</script>

<script setup>
import { useSlots } from "vue"

const slots = useSlots()

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    align: {
        type: String,
        default: "left",
    },
    truncate: {
        type: Boolean,
        default: true,
    },
})
</script>
