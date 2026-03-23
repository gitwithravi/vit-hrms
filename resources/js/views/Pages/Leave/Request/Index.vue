<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('leave.request.request')"
                :navs="[{ label: $trans('leave.leave'), path: 'Leave' }]"
            >
                <PageHeaderAction
                    url="leave/requests/"
                    name="LeaveRequest"
                    config-path="LeaveConfig"
                    :title="$trans('leave.request.request')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
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
                :header="leaveRequests.headers"
                :meta="leaveRequests.meta"
                module="leave.request"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="leaveRequest in leaveRequests.data"
                    :key="leaveRequest.uuid"
                >
                    <DataCell name="employee">
                        {{ leaveRequest.employee.name }} ({{
                            leaveRequest.employee.codeNumber
                        }})
                    </DataCell>
                    <DataCell name="leaveType">
                        {{ leaveRequest.leaveType.name }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ leaveRequest.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ leaveRequest.endDate.formatted }}
                    </DataCell>
                    <DataCell name="status">
                        <BaseBadge
                            :label="leaveRequest.status.label"
                            :design="leaveRequest.status.color"
                        />
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ leaveRequest.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'LeaveRequestShow',
                                        params: { uuid: leaveRequest.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <template v-if="leaveRequest.status.value == 'requested'">
                                <FloatingMenuItem
                                    v-if="perform('leave-request:edit')"
                                    icon="fas fa-edit"
                                    @click="
                                        router.push({
                                            name: 'LeaveRequestEdit',
                                            params: { uuid: leaveRequest.uuid },
                                        })
                                    "
                                    >{{
                                        $trans("general.edit")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    v-if="perform('leave-request:delete')"
                                    icon="fas fa-trash"
                                    @click="
                                        emitter.emit('deleteItem', {
                                            uuid: leaveRequest.uuid,
                                        })
                                    "
                                    >{{
                                        $trans("general.delete")
                                    }}</FloatingMenuItem
                                >
                            </template>
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        v-if="perform('leave-request:create')"
                        @click="router.push({ name: 'LeaveRequestCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("leave.request.request"),
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
    name: "LeaveRequestList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["filter"]
if (perform("leave-request:create")) {
    userActions.unshift("create")
}
// if (perform('leave:config')) {
//     userActions.unshift('config')
// }

let dropdownActions = []
if (perform("leave-request:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "leave/request/"
const showFilter = ref(false)

const leaveRequests = reactive({})

const setItems = (data) => {
    Object.assign(leaveRequests, data)
}
</script>
