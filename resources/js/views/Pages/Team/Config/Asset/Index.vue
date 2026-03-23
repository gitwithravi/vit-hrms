<template>
    <PageHeader
        v-if="team.uuid"
        :title="$trans(route.meta.label)"
        :navs="[
            { label: $trans('team.team'), path: 'TeamList' },
            {
                label: team.name,
                path: {
                    name: 'TeamShow',
                    params: { uuid: team.uuid },
                },
            },
            { label: $trans('team.config.config'), path: 'TeamConfig' },
        ]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <BaseCard> </BaseCard>
    </ParentTransition>
</template>

<script>
export default {}
</script>

<script setup>
import { inject } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()

const $trans = inject("$trans")

const props = defineProps({
    team: {
        type: Object,
        default() {
            return {
                name: "",
            }
        },
    },
})
</script>
