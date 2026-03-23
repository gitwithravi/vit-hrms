<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader :title="$trans('team.team')" />
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="teams.headers"
                :meta="teams.meta"
                module="team"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="team in teams.data" :key="team.uuid">
                    <DataCell name="name">
                        {{ team.name }}
                        <span v-if="team.id == currentTeamId">
                            <i
                                class="fas fa-check-circle fa-lg text-success cursor-pointer"
                            ></i>
                        </span>
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ team.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-cog"
                                @click="
                                    router.push({
                                        name: 'TeamConfig',
                                        params: { uuid: team.uuid },
                                    })
                                "
                                >{{
                                    $trans("team.config.config")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton> </template>
            </DataTable>
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "TodoList",
}
</script>

<script setup>
import { ref, reactive, computed, inject } from "vue"
import { useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

const currentTeamId = computed(() => store.getters["auth/user/currentTeamId"])
const isSuperAdmin = computed(() => store.getters["auth/user/isSuperAdmin"])

const initUrl = "team/"
const showFilter = ref(false)

const teams = reactive({})

const setItems = (data) => {
    Object.assign(teams, data)
}
</script>
