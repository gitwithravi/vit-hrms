<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('attendance.work_shift.work_shift')"
                :navs="[
                    {
                        label: $trans('attendance.attendance'),
                        path: 'Attendance',
                    },
                ]"
            >
                <PageHeaderAction
                    url="attendance/work-shifts/"
                    name="AttendanceWorkShift"
                    :title="$trans('attendance.work_shift.work_shift')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                >
                    <BaseButton
                        design="white"
                        @click="
                            router.push({ name: 'AttendanceWorkShiftAssign' })
                        "
                    >
                        {{
                            $trans("global.report", {
                                attribute: $trans(
                                    "attendance.work_shift.work_shift"
                                ),
                            })
                        }}
                    </BaseButton>
                </PageHeaderAction>
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
                module="attendance.work_shift"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="workShift in workShifts.data"
                    :key="workShift.uuid"
                >
                    <DataCell name="name">
                        {{ workShift.name }}
                    </DataCell>
                    <DataCell name="code">
                        {{ workShift.code }}
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
                                        name: 'AttendanceWorkShiftShow',
                                        params: { uuid: workShift.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('work-shift:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'AttendanceWorkShiftEdit',
                                        params: { uuid: workShift.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('work-shift:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'AttendanceWorkShiftDuplicate',
                                        params: { uuid: workShift.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('work-shift:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: workShift.uuid,
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
                        v-if="perform('work-shift:create')"
                        @click="
                            router.push({ name: 'AttendanceWorkShiftCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
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
    name: "AttendanceWorkShiftList",
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
if (perform("work-shift:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("work-shift:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "attendance/workShift/"
const showFilter = ref(false)

const workShifts = reactive({})

const setItems = (data) => {
    Object.assign(workShifts, data)
}
</script>
