<template>
    <ParentTransition appear :visibility="true">
        <div class="mx-auto w-full pb-6 lg:pb-16">
            <div
                class="space-y-4 md:grid md:grid-cols-12 md:space-x-4 md:space-y-0"
            >
                <aside
                    class="rounded-lg bg-black py-3 md:col-span-3 lg:col-span-2"
                    v-if="navigations.length > 1"
                >
                    <slot name="header"></slot>
                    <ModuleConfigSidebar :navigations="navigations" use-uuid />
                </aside>

                <div
                    :class="{
                        'md:col-span-9 lg:col-span-10': navigations.length > 1,
                        'col-span-12': navigations.length === 1,
                    }"
                >
                    <ChildTransition appear :visibility="true" direction="ltr">
                        <div class="space-y-4">
                            <slot></slot>
                        </div>
                    </ChildTransition>
                </div>
            </div>
        </div>
    </ParentTransition>
</template>

<script>
export default {
    name: "ModuleConfig",
}
</script>

<script setup>
const props = defineProps({
    navigations: {
        type: Array,
        default: [],
    },
    useUuid: {
        type: Boolean,
        default: false,
    },
})
</script>
