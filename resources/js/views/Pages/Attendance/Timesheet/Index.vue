<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <TimesheetReportModal
            :visibility="showTimesheetReport"
            @close="showTimesheetReport = false"
        />
        <template #header>
            <PageHeader
                :title="$trans('attendance.timesheet.timesheet')"
                :navs="[
                    {
                        label: $trans('attendance.attendance'),
                        path: 'Attendance',
                    },
                ]"
            >
                <PageHeaderAction
                    url="attendance/timesheets/"
                    name="AttendanceTimesheet"
                    :title="$trans('attendance.timesheet.timesheet')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                    @toggleImport="showImport = !showImport"
                >
                    <BaseButton
                        v-if="perform('timesheet:export')"
                        design="white"
                        @click="showTimesheetReport = true"
                    >
                        <i class="fas fa-download mr-2"></i>
                        Export Timesheet Report
                    </BaseButton>
                    <BaseButton
                        design="white"
                        v-if="
                            perform('timesheet:sync') &&
                            route.query.startDate &&
                            route.query.endDate
                        "
                        @click="sync"
                        :disabled="isLoading"
                    >
                        <i
                            class="fas fa-rotate mr-2"
                            :class="{
                                'fa-spin': isLoading,
                            }"
                        ></i>
                        {{
                            $trans("global.sync", {
                                attribute: $trans(
                                    "attendance.timesheet.timesheet"
                                ),
                            })
                        }}
                    </BaseButton>
                </PageHeaderAction>
            </PageHeader>
        </template>

        <template #import>
            <ParentTransition appear :visibility="showImport">
                <BaseImport
                    path="attendance/timesheets/import"
                    @cancelled="showImport = false"
                    @hide="showImport = false"
                    @completed="emitter.emit('listItems')"
                />
            </ParentTransition>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <template #after-filter>
            <BaseAlert
                design="info"
                size="xs"
                v-if="
                    perform('timesheet:sync') &&
                    (!route.query.startDate || !route.query.endDate)
                "
            >
                {{ $trans("attendance.timesheet.choose_date_range_to_sync") }}
            </BaseAlert>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="timesheets.headers"
                :meta="timesheets.meta"
                module="attendance.timesheet"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="timesheet in timesheets.data"
                    :key="timesheet.uuid"
                >
                    <DataCell name="employee">
                        {{ timesheet.employee.name }} ({{
                            timesheet.employee.codeNumber
                        }})
                    </DataCell>
                    <DataCell name="designation">
                        {{ timesheet.employee.designation }}
                    </DataCell>
                    <DataCell name="branch">
                        {{ timesheet.employee.branch }}
                    </DataCell>
                    <DataCell name="workShift">
                        <span class="mr-1">
                            <i
                                class="fas fa-moon fa-xs"
                                v-if="timesheet.isOvernight"
                            ></i>
                        </span>
                        {{ timesheet.workShift?.name }} ({{
                            timesheet.workShift?.code
                        }})
                    </DataCell>
                    <DataCell name="date">
                        {{ timesheet.date.formatted }}
                        <BaseBadge v-if="timesheet.isManual" type="info">{{
                            $trans("attendance.timesheet.props.manual")
                        }}</BaseBadge>
                        <div
                            class="text-danger text-xs"
                            v-if="timesheet.status && timesheet.status != 'ok'"
                        >
                            {{ timesheet.status.label }}
                        </div>
                        <TextMuted block>{{ timesheet.day }}</TextMuted>
                    </DataCell>
                    <DataCell name="inAt">
                        {{ timesheet.inAtTime.formatted }}
                        <TextMuted block v-if="timesheet.isOvernight">{{
                            timesheet.inAtDate.formatted
                        }}</TextMuted>
                    </DataCell>
                    <DataCell name="outAt">
                        {{ timesheet.outAtTime.formatted }}
                        <TextMuted block v-if="timesheet.isOvernight">{{
                            timesheet.outAtDate.formatted
                        }}</TextMuted>
                    </DataCell>
                    <DataCell name="duration">
                        {{ timesheet.duration }}
                        <span v-if="timesheet.status == 'ok'"
                            ><i class="fas fa-check-circle text-success"></i
                        ></span>
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'AttendanceTimesheetShow',
                                        params: { uuid: timesheet.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('timesheet:edit') &&
                                    timesheet.isEditable
                                "
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'AttendanceTimesheetEdit',
                                        params: { uuid: timesheet.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('timesheet:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'AttendanceTimesheetDuplicate',
                                        params: { uuid: timesheet.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('timesheet:delete') &&
                                    timesheet.isDeletable
                                "
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: timesheet.uuid,
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
                        v-if="perform('timesheet:create')"
                        @click="
                            router.push({ name: 'AttendanceTimesheetCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "attendance.timesheet.timesheet"
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
    name: "AttendanceTimesheetList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"
import { confirmAction } from "@core/helpers/alert"
import FilterForm from "./Filter.vue"
import TimesheetReportModal from "./ReportModal.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

let userActions = ["filter"]
if (perform("timesheet:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("timesheet:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

if (perform("timesheet:import")) {
    dropdownActions.unshift("import")
}

const initUrl = "attendance/timesheet/"
const isLoading = ref(false)
const showFilter = ref(false)
const showImport = ref(false)
const showTimesheetReport = ref(false)

const timesheets = reactive({})

const setItems = (data) => {
    Object.assign(timesheets, data)
}

const sync = async () => {
    if (isLoading.value) {
        return
    }

    if (!(await confirmAction())) {
        return
    }

    isLoading.value = true

    await store
        .dispatch(initUrl + "sync", {
            params: route.query,
        })
        .then((response) => {
            isLoading.value = false
            emitter.emit("listItems")
        })
        .catch((e) => {
            isLoading.value = false
        })
}
</script>
