<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('leave.allocation.allocation')"
                :navs="[{ label: $trans('leave.leave'), path: 'Leave' }]"
            >
                <PageHeaderAction
                    url="leave/allocations/"
                    name="LeaveAllocation"
                    :title="$trans('leave.allocation.allocation')"
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
                :header="leaveAllocations.headers"
                :meta="leaveAllocations.meta"
                module="leave.allocation"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="leaveAllocation in leaveAllocations.data"
                    :key="leaveAllocation.uuid"
                >
                    <DataCell name="employee">
                        {{ leaveAllocation.employee.name }} ({{
                            leaveAllocation.employee.codeNumber
                        }})
                    </DataCell>
                    <DataCell name="designation">
                        {{ leaveAllocation.employee.designation }}
                    </DataCell>
                    <DataCell name="branch">
                        {{ leaveAllocation.employee.branch }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ leaveAllocation.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ leaveAllocation.endDate.formatted }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ leaveAllocation.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'LeaveAllocationShow',
                                        params: { uuid: leaveAllocation.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('leave-allocation:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'LeaveAllocationEdit',
                                        params: { uuid: leaveAllocation.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('leave-allocation:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'LeaveAllocationDuplicate',
                                        params: { uuid: leaveAllocation.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('leave-allocation:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: leaveAllocation.uuid,
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
                        v-if="perform('leave-allocation:create')"
                        @click="router.push({ name: 'LeaveAllocationCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "leave.allocation.allocation"
                                ),
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
    name: "LeaveAllocationList",
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
if (perform("leave-allocation:create")) {
    userActions.unshift("create")
}
// if (perform('leave:config')) {
//     userActions.unshift('config')
// }

let dropdownActions = []
if (perform("leave-allocation:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "leave/allocation/"
const showFilter = ref(false)

const leaveAllocations = reactive({})

const setItems = (data) => {
    Object.assign(leaveAllocations, data)
}
</script>
