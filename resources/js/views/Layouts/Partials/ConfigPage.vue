<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('config.config'), path: 'Config' }]"
    >
        <slot name="action"></slot>
    </PageHeader>
    <ParentTransition appear :visibility="true">
        <div class="mx-auto w-full pb-6 lg:pb-16">
            <div class="">
                <div
                    class="space-x-2 divide-y divide-gray-200 dark:divide-gray-700 sm:grid sm:grid-cols-12 sm:divide-x sm:divide-y-0"
                >
                    <ConfigSidebar />

                    <div
                        class="sm:col-span-9 lg:col-span-10"
                        :class="{
                            'dark:bg-dark-header rounded-lg bg-white p-4':
                                !noBackground,
                        }"
                    >
                        <ChildTransition
                            appear
                            :visibility="true"
                            direction="ltr"
                        >
                            <slot></slot>
                        </ChildTransition>
                    </div>
                </div>
            </div>
        </div>
    </ParentTransition>
</template>

<script>
export default {
    name: "ConfigPage",
}
</script>

<script setup>
import { useRoute } from "vue-router"

const route = useRoute()

const props = defineProps({
    noBackground: {
        type: Boolean,
        default: false,
    },
})
</script>
