<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="team.uuid"
                :title="$trans('team.config.role.role')"
                :navs="[]"
            >
                <PageHeaderAction
                    :url="`teams/${team.uuid}/roles/`"
                    name="TeamConfigRole"
                    :title="$trans('team.config.role.role')"
                    :actions="['create', 'filter']"
                    :dropdown-actions="['print', 'pdf', 'excel']"
                    @toggleFilter="showFilter = !showFilter"
                />
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="roles.headers"
                :meta="roles.meta"
                module="team.config.role"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="role in roles.data" :key="role.uuid">
                    <DataCell name="name">
                        {{ role.label }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ role.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu v-if="!role.isDefault">
                            <FloatingMenuItem
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: route.params.uuid,
                                        moduleUuid: role.uuid,
                                    })
                                "
                                >{{
                                    $trans("general.delete")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        @click="router.push({ name: 'TeamConfigRoleCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("team.config.role.role"),
                            })
                        }}
                    </BaseButton>
                </template>
            </DataTable>
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "TeamConfigRoleList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

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

const initUrl = "team/role/"
const showFilter = ref(false)

const roles = reactive({})

const setItems = (data) => {
    Object.assign(roles, data)
}
</script>
