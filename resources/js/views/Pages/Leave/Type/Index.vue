<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('leave.type.type')"
                :navs="[{ label: $trans('leave.leave'), path: 'Leave' }]"
            >
                <PageHeaderAction
                    url="leave/types/"
                    name="LeaveType"
                    :title="$trans('leave.type.type')"
                    :actions="userActions"
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
                :header="leaveTypes.headers"
                :meta="leaveTypes.meta"
                module="leave.type"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="leaveType in leaveTypes.data"
                    :key="leaveType.uuid"
                >
                    <DataCell name="name">
                        {{ leaveType.name }}
                    </DataCell>
                    <DataCell name="code">
                        {{ leaveType.code }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ leaveType.alias }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ leaveType.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'LeaveTypeShow',
                                        params: { uuid: leaveType.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'LeaveTypeEdit',
                                        params: { uuid: leaveType.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'LeaveTypeDuplicate',
                                        params: { uuid: leaveType.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: leaveType.uuid,
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
                        @click="router.push({ name: 'LeaveTypeCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("leave.type.type"),
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
    name: "LeaveTypeList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["create", "filter"]

const initUrl = "leave/type/"
const showFilter = ref(false)

const leaveTypes = reactive({})

const setItems = (data) => {
    Object.assign(leaveTypes, data)
}
</script>
