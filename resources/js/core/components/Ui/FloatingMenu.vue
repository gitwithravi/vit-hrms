<template>
    <div class="relative flex items-center justify-end">
        <VMenu
            placement="left-end"
            :triggers="['hover', 'focus', 'click']"
            :autoHide="true"
        >
            <div
                class="dark:bg-dark-header inline-flex items-center justify-center rounded-full bg-transparent text-gray-400 hover:text-gray-500"
                :class="{
                    'h-5 w-5': slim,
                    'h-8': !slim,
                    'w-8': !noWidth,
                }"
            >
                <EllipsisVerticalIcon class="h-5 w-5" />
            </div>

            <template #popper>
                <div
                    class="divide-y divide-gray-200 bg-white dark:divide-gray-600 dark:border dark:border-gray-700 dark:bg-neutral-800"
                >
                    <slot></slot>
                </div>
            </template>
        </VMenu>
    </div>
</template>

<script>
export default {
    name: "FloatingMenu",
}
</script>

<script setup>
const props = defineProps({
    slim: {
        type: Boolean,
        default: false,
    },
    noWidth: {
        type: Boolean,
        default: false,
    },
    topMargin: {
        type: Boolean,
        default: false,
    },
    doubleTopMargin: {
        type: Boolean,
        default: false,
    },
    rightMargin: {
        type: Boolean,
        default: true,
    },
})
</script>
