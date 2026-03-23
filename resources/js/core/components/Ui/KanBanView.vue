<template>
    <div
        class="scroller-thin-x scroller-hidden scrollbar-track-transparent scrollbar-thumb-body dark:scrollbar-thumb-dm-body"
    >
        <div class="flex space-x-2">
            <slot></slot>
            <div
                class="flex w-80 flex-shrink-0 flex-col rounded-md bg-gray-100 p-3 dark:bg-neutral-800"
                v-if="addList"
            >
                <h3
                    class="mb-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                >
                    <span class="text-gray-600 dark:text-gray-500">
                        <slot name="addListTitle"></slot>
                    </span>
                </h3>

                <slot name="addListForm"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "KanBanView",
}
</script>

<script setup>
const props = defineProps({
    addList: {
        type: Boolean,
        default: false,
    },
})
</script>
