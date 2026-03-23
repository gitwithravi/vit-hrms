<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="employee.uuid"
                :title="$trans('attendance.work_shift.work_shift')"
                :navs="[
                    { label: $trans('employee.employee'), path: 'Employee' },
                    {
                        label: employee.contact.name,
                        path: {
                            name: 'EmployeeShow',
                            params: { uuid: employee.uuid },
                        },
                    },
                ]"
            >
                <PageHeaderAction
                    :url="`employees/${employee.uuid}/work-shifts/`"
                    name="EmployeeWorkShift"
                    :title="$trans('attendance.work_shift.work_shift')"
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
                :header="workShifts.headers"
                :meta="workShifts.meta"
                module="employee.work_shift"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="workShift in workShifts.data"
                    :key="workShift.uuid"
                >
                    <DataCell name="workShift">
                        {{ workShift.workShift.name }} ({{
                            workShift.workShift.code
                        }})
                    </DataCell>
                    <DataCell name="startDate">
                        {{ workShift.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ workShift.endDate.formatted }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ workShift.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeWorkShiftShow',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: workShift.uuid,
                                        },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'EmployeeWorkShiftEdit',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: workShift.uuid,
                                        },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'EmployeeWorkShiftDuplicate',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: workShift.uuid,
                                        },
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
                                        uuid: employee.uuid,
                                        moduleUuid: workShift.uuid,
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
                        v-if="perform('work-shift:assign')"
                        @click="
                            router.push({ name: 'EmployeeWorkShiftCreate' })
                        "
                    >
                        {{
                            $trans("global.assign", {
                                attribute: $trans(
                                    "attendance.work_shift.work_shift"
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
    name: "EmployeeWorkShiftList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

let userActions = ["filter"]
if (perform("work-shift:assign")) {
    userActions.unshift("create")
}

const initUrl = "employee/workShift/"
const showFilter = ref(false)

const workShifts = reactive({})

const setItems = (data) => {
    Object.assign(workShifts, data)
}
</script>
