<template>
    <div
        :class="{
            'scroller-thin-x scroller-hidden scrollbar-track-transparent scrollbar-thumb-body dark:scrollbar-thumb-dm-body':
                scroll,
        }"
    >
        <table
            class="hidden min-w-full divide-y divide-gray-200 dark:divide-gray-700 md:table"
            :class="{
                'rounded-table': corner == 'rounded',
            }"
        >
            <thead class="bg-gray-50 dark:bg-neutral-700">
                <tr>
                    <th
                        v-for="item in header"
                        :key="item.key"
                        scope="col"
                        class="py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:px-2 xl:px-4"
                        :class="{
                            'border border-gray-200 dark:border-gray-600':
                                bordered,
                            'text-right': item.align == 'right',
                            'text-center': item.align == 'center',
                        }"
                    >
                        {{ item.label }}
                    </th>

                    <slot name="header"></slot>
                </tr>
            </thead>
            <tbody
                class="divide-y divide-gray-200 bg-white dark:divide-gray-700"
            >
                <slot></slot>
            </tbody>

            <tfoot class="bg-gray-50 dark:bg-neutral-700" v-if="$slots.footer">
                <tr>
                    <slot name="footer"></slot>
                </tr>
            </tfoot>
        </table>

        <table
            class="min-w-full md:hidden"
            :class="{
                'divide-y divide-gray-200 dark:divide-gray-700': !bordered,
            }"
        >
            <tbody
                class="bg-white"
                :class="{
                    'divide-y divide-gray-200 dark:divide-gray-700': !bordered,
                }"
            >
                <slot></slot>
            </tbody>

            <tfoot v-if="$slots.footer">
                <slot name="footer"></slot>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    name: "SimpleTable",
}
</script>

<script setup>
import { useSlots, provide, computed } from "vue"
import { useRoute, useRouter } from "vue-router"

const route = useRoute()
const router = useRouter()
const slots = useSlots()

const emit = defineEmits(["refresh"])

const props = defineProps({
    header: {
        type: Array,
        default: [],
    },
    subHeader: {
        type: Array,
        default: [],
    },
    footer: {
        type: Array,
        default: [],
    },
    bordered: {
        type: Boolean,
        default: false,
    },
    scroll: {
        type: Boolean,
        default: true,
    },
    corner: {
        type: String,
        default: "rounded",
    },
    verticalAlign: {
        type: String,
        default: "top",
        validator(value) {
            return ["top", "bottom", "middle"].includes(value)
        },
    },
})

provide(
    "Header",
    computed(() => props.header)
)
provide(
    "SubHeader",
    computed(() => props.subHeader)
)
provide(
    "VerticalAlign",
    computed(() => props.verticalAlign)
)
</script>
