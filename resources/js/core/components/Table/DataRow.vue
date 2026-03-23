<template>
    <tr
        class="dark:hover:bg-dark-body hover:bg-gray-100"
        :class="{
            'hidden md:table-row': !noResponsive,
            'bg-gray-100 font-semibold dark:bg-neutral-600': isHeading,
        }"
    >
        <slot></slot>
    </tr>

    <div
        v-if="!noResponsive"
        class="dark:bg-dark-header dark:hover:bg-dark-body table-row hover:bg-gray-100 md:hidden"
        :class="{
            'space-y-2': spacing,
            'bg-gray-100 font-semibold dark:bg-neutral-600': isHeading,
        }"
    >
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "DataRow",
}
</script>

<script setup>
import { provide, computed } from "vue"

const props = defineProps({
    noResponsive: {
        type: Boolean,
        default: false,
    },
    isHeading: {
        type: Boolean,
        default: false,
    },
    spacing: {
        type: Boolean,
        default: true,
    },
    textColor: {
        type: String,
        default: "",
    },
})

provide(
    "TextColor",
    computed(() => props.textColor)
)
</script>
