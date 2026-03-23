<template>
    <PageHeader :title="$trans(route.meta.label)" :navs="[]">
        <PageHeaderAction
            url="attendance/"
            name="Attendance"
            :title="$trans('attendance.attendance')"
            :actions="userActions"
            :dropdown-actions="dropdownActions"
        >
            <BaseButton
                v-if="perform('attendance:mark')"
                design="white"
                @click="showSyncHolidays = true"
            >
                Sync Holidays
            </BaseButton>
            <BaseButton
                v-if="perform('attendance:export')"
                design="white"
                @click="showAttendanceReport = true"
            >
                Download Report
            </BaseButton>
            <BaseButton
                v-if="perform('attendance:mark')"
                design="white"
                @click="router.push({ name: 'AttendanceMark' })"
            >
                {{ $trans("attendance.mark") }}
            </BaseButton>
        </PageHeaderAction>
    </PageHeader>

    <SyncHolidaysModal
        :visibility="showSyncHolidays"
        @close="showSyncHolidays = false"
        @completed="listAttendance"
    />

    <AttendanceReportModal
        :visibility="showAttendanceReport"
        @close="showAttendanceReport = false"
    />

    <ParentTransition appear :visibility="true">
        <FilterForm
            @afterFilter="listAttendance"
            :init-url="initUrl"
            date-as="month"
            day-wise-filter
        ></FilterForm>
    </ParentTransition>

    <ParentTransition appear :visibility="true">
        <BaseCard no-padding no-content-padding :is-loading="isLoading">
            <DataTable
                :header="employees.headers"
                :meta="employees.meta"
                module="attendance"
                @refresh="listAttendance"
            >
                <DataRow
                    v-for="employee in employees.data"
                    :key="employee.uuid"
                >
                    <DataCell name="employee">
                        <BaseDataView
                            :label="
                                employee.name + ' (' + employee.codeNumber + ')'
                            "
                            revert
                        >
                            {{ employee.designation }} {{ employee.branch }}
                        </BaseDataView>
                    </DataCell>
                    <template v-if="dayWise">
                        <DataCell
                            v-for="(attendance, index) in employee.attendances"
                            :name="`day${index}`"
                        >
                            <span
                                :class="[
                                    'font-semibold',
                                    'text-xs',
                                    'text-' + attendance.color,
                                ]"
                                >{{ attendance.code }}</span
                            >
                        </DataCell>
                    </template>
                    <template v-else>
                        <DataCell
                            align="center"
                            v-for="(summary, index) in employee.summary"
                            :name="`type_${index}`"
                        >
                            <span>{{ summary }}</span>
                            <TextMuted v-if="index == 'Late'" class="ml-1">
                                ({{
                                    employee.additionalSummary
                                        ?.totalLateDuration +
                                    $trans("list.durations.m_short")
                                }})
                            </TextMuted>
                            <TextMuted
                                v-if="index == 'EarlyLeaving'"
                                class="ml-1"
                            >
                                ({{
                                    employee.additionalSummary
                                        ?.totalEarlyLeavingDuration +
                                    $trans("list.durations.m_short")
                                }})
                            </TextMuted>
                            <TextMuted v-if="index == 'Overtime'" class="ml-1">
                                ({{
                                    employee.additionalSummary
                                        ?.totalOvertimeDuration +
                                    $trans("list.durations.m_short")
                                }})
                            </TextMuted>
                        </DataCell>
                    </template>
                </DataRow>
            </DataTable>
        </BaseCard>
    </ParentTransition>
</template>

<script>
export default {
    name: "AttendanceList",
}
</script>

<script setup>
import { ref, reactive, computed, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"
import { toBoolean } from "@core/helpers/string"
import FilterForm from "./Filter.vue"
import SyncHolidaysModal from "./SyncHolidaysModal.vue"
import AttendanceReportModal from "./AttendanceReportModal.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

let userActions = []
if (perform("attendance:config")) {
    userActions.unshift("config")
}

let dropdownActions = []
if (perform("attendance:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "attendance/"
const isLoading = ref(false)
const showSyncHolidays = ref(false)
const showAttendanceReport = ref(false)

const dayWise = computed(() => toBoolean(route.query.dayWise))

const employees = reactive({
    headers: [],
    data: [],
    meta: { total: 0 },
})

const listAttendance = async () => {
    isLoading.value = true
    await store
        .dispatch(initUrl + "listAttendance", {
            params: route.query,
        })
        .then((response) => {
            isLoading.value = false
            Object.assign(employees, response)
        })
        .catch((e) => {
            isLoading.value = false
        })
}

onMounted(async () => {
    if (route.query.date) {
        await listAttendance()
    }
})
</script>
