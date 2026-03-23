<template>
    <PageHeader
        v-if="team.uuid"
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
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
            { label: $trans('team.config.role.role'), path: 'TeamConfigRole' },
        ]"
    >
        <PageHeaderAction
            name="TeamConfigRole"
            :title="$trans('team.config.role.role')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <RoleForm></RoleForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "RoleAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import RoleForm from "./Form.vue"

const route = useRoute()

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
