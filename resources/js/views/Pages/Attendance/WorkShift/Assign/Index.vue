<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, { attribute: $trans(route.meta.label) })
        "
        :navs="[
            { label: $trans('attendance.attendance'), path: 'Attendance' },
            {
                label: $trans('attendance.work_shift.work_shift'),
                path: 'AttendanceWorkShiftReport',
            },
        ]"
    >
        <PageHeaderAction>
            <BaseButton
                design="white"
                @click="router.push({ name: 'AttendanceWorkShiftReport' })"
            >
                {{
                    $trans("global.report", {
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
            {{ $trans("attendance.work_shift.assign") }}
        </template>

        <template #action>
            <DropdownButton
                v-if="preRequisites.workShifts"
                :label="$trans('attendance.work_shift.work_shift')"
            >
                <div
                    v-for="workShift in preRequisites.workShifts"
                    :key="workShift.uuid"
                >
                    <DropdownItem as="span" @click="updateWorkShift(workShift)">
                        {{ workShift.name }} ({{ workShift.code }})
                    </DropdownItem>
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
            pre-requisite-custom-url="assignPreRequisite"
            @setPreRequisites="setPreRequisites"
            action="assign"
            :init-form="initForm"
            :form="form"
            :after-submit="afterSubmit"
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
                        </BaseDataView>
                    </div>
                    <template v-if="employee.workShifts.length">
                        <div class="col-span-3 sm:col-span-2">
                            <template v-for="workShift in employee.workShifts">
                                <BaseDataView
                                    :label="
                                        workShift.name +
                                        ' (' +
                                        workShift.code +
                                        ')'
                                    "
                                    revert
                                >
                                    {{ workShift.startDate.formatted }} -
                                    {{ workShift.endDate.formatted }}
                                </BaseDataView>
                            </template>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-span-3 sm:col-span-1">
                            <BaseSelect
                                v-model="employee.workShift"
                                :name="`employees.${index}.workShift`"
                                :placeholder="
                                    $trans('attendance.work_shift.work_shift')
                                "
                                :options="preRequisites.workShifts"
                                value-prop="uuid"
                                v-model:error="
                                    formErrors[`employees.${index}.workShift`]
                                "
                            >
                                <template #selectedOption="slotProps">
                                    {{ slotProps.value.name }} ({{
                                        slotProps.value.code
                                    }})
                                </template>

                                <template #listOption="slotProps">
                                    {{ slotProps.option.name }} ({{
                                        slotProps.option.code
                                    }})
                                </template>
                            </BaseSelect>
                        </div>
                        <div class="col-span-3 sm:col-span-1">
                            <BaseTextarea
                                :rows="1"
                                v-model="employee.remarks"
                                :name="`employees.${index}.remarks`"
                                :placeholder="
                                    $trans(
                                        'attendance.work_shift.props.remarks'
                                    )
                                "
                                v-model:error="
                                    formErrors[`details.${index}.remarks`]
                                "
                            />
                        </div>
                    </template>
                </div>
            </div>
        </FormAction>

        <Pagination :meta="state.meta" @refresh="fetchEmployee"></Pagination>
    </BaseCard>
</template>

<script>
export default {
    name: "AttendanceWorkShiftAssign",
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

const initUrl = "attendance/workShift/"
const isLoading = ref(false)

const preRequisites = reactive({
    workShifts: [],
})
const formErrors = getFormErrors(initUrl)
const form = reactive({ ...initForm })
const state = reactive({
    meta: {},
})

const updateWorkShift = (workShift) => {
    form.employees.forEach((employee) => {
        if (employee.workShifts.length == 0) {
            employee.workShift = workShift.uuid
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

const afterSubmit = async () => {
    await fetchEmployee()
}

onMounted(async () => {
    if (route.query.startDate && route.query.endDate) {
        await fetchEmployee()
    }
})
</script>
