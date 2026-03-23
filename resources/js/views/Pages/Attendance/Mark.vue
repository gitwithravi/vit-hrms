<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('attendance.attendance'), path: 'Attendance' }]"
    >
        <PageHeaderAction>
            <BaseButton
                design="white"
                @click="router.push({ name: 'AttendanceList' })"
            >
                {{
                    $trans("global.list", {
                        attribute: $trans("attendance.attendance"),
                    })
                }}
            </BaseButton>
            <BaseButton
                design="primary"
                @click="router.push({ name: 'AttendanceProduction' })"
            >
                {{ $trans("attendance.mark_production") }}
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
        v-if="route.query.date"
    >
        <template #title>
            {{ $trans("attendance.mark") }}
        </template>

        <template #action>
            <DropdownButton
                v-if="preRequisites.attendanceTypes"
                :label="
                    state.defaultAttendanceType.uuid
                        ? state.defaultAttendanceType.name
                        : $trans('attendance.type.type')
                "
            >
                <div
                    v-for="attendanceType in preRequisites.attendanceTypes"
                    :key="attendanceType.uuid"
                >
                    <template
                        v-if="
                            attendanceType.uuid !=
                            state.defaultAttendanceType.name
                        "
                    >
                        <DropdownItem
                            as="span"
                            @click="updateAttendanceType(attendanceType)"
                        >
                            {{ attendanceType.name }}
                        </DropdownItem>
                    </template>
                </div>
            </DropdownButton>
        </template>

        <div class="p-2">
            <BaseAlert
                size="xs"
                design="error"
                v-if="form.employees.length == 0"
                >{{ $trans("general.errors.record_not_found") }}</BaseAlert
            >
        </div>

        <FormAction
            v-if="form.employees.length"
            no-card
            button-padding
            :keep-adding="false"
            :stay-on="true"
            :init-url="initUrl"
            :pre-requisites="true"
            @setPreRequisites="setPreRequisites"
            action="markAttendance"
            :init-form="initForm"
            :form="form"
        >
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <div
                    class="grid grid-cols-3 gap-6 px-4 py-2"
                    v-for="(employee, index) in form.employees"
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
                            <span
                                class="ml-2"
                                v-if="employee.timeBasedAttendance"
                                v-tooltip="$trans('attendance.is_time_based')"
                                ><i class="fas fa-clock text-info"></i
                            ></span>
                        </BaseDataView>
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <template v-if="employee.onLeave">
                            <BaseDataView
                                :label="$trans('leave.on_leave')"
                                revert
                            >
                                {{ employee.leavePeriod }}
                            </BaseDataView>
                        </template>
                        <template v-else>
                            <BaseSelect
                                :disabled="employee.timeBasedAttendance"
                                v-model="employee.attendanceType"
                                :name="`employees.${index}.attendanceType`"
                                :placeholder="$trans('attendance.type.type')"
                                :options="preRequisites.attendanceTypes"
                                value-prop="uuid"
                                label-prop="name"
                                v-model:error="
                                    formErrors[
                                        `employees.${index}.attendanceType`
                                    ]
                                "
                            />
                        </template>
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseTextarea
                            :rows="1"
                            v-model="employee.remarks"
                            :name="`employees.${index}.remarks`"
                            :placeholder="$trans('attendance.props.remarks')"
                            v-model:error="
                                formErrors[`details.${index}.remarks`]
                            "
                        />
                    </div>
                </div>
            </div>
        </FormAction>

        <Pagination :meta="state.meta" @refresh="fetchEmployee"></Pagination>
    </BaseCard>
</template>

<script>
export default {
    name: "AttendanceMark",
}
</script>

<script setup>
import { ref, reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

const initForm = {
    employees: [],
}

const initUrl = "attendance/"
const isLoading = ref(false)

const preRequisites = reactive({
    attendanceTypes: [],
})
const formErrors = getFormErrors(initUrl)
const form = reactive({ ...initForm })
const state = reactive({
    meta: {},
    defaultAttendanceType: {},
})

const updateAttendanceType = (attendanceType) => {
    state.defaultAttendanceType = attendanceType
    form.employees.forEach((employee) => {
        if (!employee.timeBasedAttendance) {
            employee.attendanceType = attendanceType.uuid
        }
    })
}

const fetchEmployee = async () => {
    isLoading.value = true
    await store
        .dispatch(initUrl + "fetchEmployee", {
            params: route.query,
        })
        .then((response) => {
            isLoading.value = false
            initForm.employees = response.data
            state.meta = response.meta
            Object.assign(form, cloneDeep(initForm))
        })
        .catch((e) => {
            isLoading.value = false
        })
}

const resetForm = () => {
    Object.assign(form, cloneDeep(initForm))
}

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

onMounted(async () => {
    if (route.query.date) {
        await fetchEmployee()
    }
})
</script>
