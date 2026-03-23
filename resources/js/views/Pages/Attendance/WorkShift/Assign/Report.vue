<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, { attribute: $trans(route.meta.label) })
        "
        :navs="[{ label: $trans('attendance.attendance'), path: 'Attendance' }]"
    >
        <PageHeaderAction>
            <BaseButton
                v-if="perform('work-shift:assign')"
                design="primary"
                @click="router.push({ name: 'AttendanceWorkShiftAssign' })"
            >
                {{
                    $trans("global.assign", {
                        attribute: $trans("attendance.work_shift.work_shift"),
                    })
                }}
            </BaseButton>
            <BaseButton
                design="white"
                @click="router.push({ name: 'AttendanceWorkShift' })"
            >
                {{
                    $trans("global.list", {
                        attribute: $trans("attendance.work_shift.work_shift"),
                    })
                }}
            </BaseButton>
        </PageHeaderAction>
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FilterForm
            @afterFilter="fetchEmployee"
            :init-url="initUrl"
        ></FilterForm>
    </ParentTransition>

    <BaseCard
        no-padding
        no-content-padding
        :is-loading="isLoading"
        v-if="route.query.startDate && route.query.endDate"
    >
        <template #title>
            {{ $trans("attendance.work_shift.work_shift") }}
        </template>

        <div class="p-2">
            <BaseAlert
                size="xs"
                design="error"
                v-if="state.employees.length == 0"
                >{{ $trans("general.errors.record_not_found") }}</BaseAlert
            >
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <div
                class="grid grid-cols-3 gap-6 px-4 py-2"
                v-for="(employee, index) in state.employees"
                :key="employee.uuid"
            >
                <div class="col-span-3 sm:col-span-1">
                    <BaseDataView
                        :label="
                            employee.name + ' (' + employee.codeNumber + ')'
                        "
                        revert
                    >
                        {{ employee.designation }} {{ employee.branch }}
                    </BaseDataView>
                </div>
                <div class="col-span-3 sm:col-span-2">
                    <template v-if="employee.workShifts.length">
                        <template v-for="workShift in employee.workShifts">
                            <BaseDataView
                                :label="
                                    workShift.name + '(' + workShift.code + ')'
                                "
                                revert
                            >
                                {{ workShift.startDate.formatted }} -
                                {{ workShift.endDate.formatted }}
                            </BaseDataView>
                        </template>
                    </template>
                    <template v-else> - </template>
                </div>
            </div>
        </div>

        <Pagination :meta="state.meta" @refresh="fetchEmployee"></Pagination>
    </BaseCard>
</template>

<script>
export default {
    name: "AttendanceWorkShiftReport",
}
</script>

<script setup>
import { ref, reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

const initUrl = "attendance/workShift/"
const isLoading = ref(false)

const state = reactive({
    employees: [],
    meta: {},
})

const fetchEmployee = async () => {
    isLoading.value = true
    await store
        .dispatch(initUrl + "fetchEmployee", {
            params: route.query,
        })
        .then((response) => {
            isLoading.value = false
            state.employees = response.data
            state.meta = response.meta
        })
        .catch((e) => {
            isLoading.value = false
        })
}

onMounted(async () => {
    if (route.query.startDate && route.query.endDate) {
        await fetchEmployee()
    }
})
</script>
