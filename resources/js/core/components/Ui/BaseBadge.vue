<template>
    <template v-if="design != 'custom' || (design == 'custom' && color)">
        <span
            class="items-center font-medium"
            :class="{
                'cursor-pointer': clickable,
                'mt-1 block': block,
                'inline-flex': !block,
                'px-2.5 py-0.5 text-xs leading-4': size === 'sm',
                'px-3 py-0.5 text-sm': size === 'md',
                'px-4 py-1 text-base': size === 'lg',
                'rounded-full': roundedFull,
                'rounded-md': !roundedFull,
                'bg-primary text-secondary dark:bg-gray-700 dark:text-gray-200':
                    design === 'primary',
                'bg-secondary text-primary': design === 'secondary',
                'bg-success text-secondary': design === 'success',
                'bg-info text-secondary': design === 'info',
                'bg-warning text-secondary': design === 'warning',
                'bg-danger text-secondary':
                    design === 'danger' || design === 'error',
            }"
            :style="
                design === 'custom'
                    ? `background-color: ${color}; color: #fff;`
                    : ''
            "
        >
            {{ label }}
            <slot></slot>
        </span>
    </template>
    <template v-else>
        {{ label }}
        <slot></slot>
    </template>
</template>

<script>
export default {
    name: "BaseBadge",
}
</script>

<script setup>
import { computed } from "vue"

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    size: {
        type: String,
        validator(value) {
            return ["sm", "md", "lg"].includes(value)
        },
        default: "sm",
    },
    roundedFull: Boolean,
    design: {
        type: String,
        validator(value) {
            return [
                "primary",
                "secondary",
                "info",
                "success",
                "warning",
                "danger",
                "error",
                "custom",
            ].includes(value)
        },
        default: "primary",
    },
    color: {
        type: String,
        default: "",
    },
    block: {
        type: Boolean,
        default: false,
    },
    clickable: {
        type: Boolean,
        default: false,
    },
})

const hasNoColor = computed(() => {
    if (props.design === "custom" && _.isEmpty(props.color)) {
        return true
    }

    return false
})
</script>
