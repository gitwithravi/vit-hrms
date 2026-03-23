<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1" v-if="dateAs == 'date'">
                <DatePicker
                    v-model="form.date"
                    name="date"
                    :label="$trans('attendance.props.date')"
                    no-clear
                    v-model:error="formErrors.date"
                />
            </div>
            <div class="col-span-3 sm:col-span-1" v-if="dateAs == 'month'">
                <DatePicker
                    as="month"
                    v-model="form.date"
                    name="date"
                    :label="$trans('attendance.props.date')"
                    no-clear
                    v-model:error="formErrors.date"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.codeNumber"
                    name="codeNumber"
                    :label="$trans('employee.props.code_number')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="department"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('company.department.department'),
                        })
                    "
                    v-model="form.department"
                    value-prop="uuid"
                    :init-search="fetchData.department"
                    search-action="company/department/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="designation"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'company.designation.designation'
                            ),
                        })
                    "
                    v-model="form.designation"
                    value-prop="uuid"
                    :init-search="fetchData.designation"
                    search-action="company/designation/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="branch"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('company.branch.branch'),
                        })
                    "
                    v-model="form.branch"
                    value-prop="uuid"
                    :init-search="fetchData.branch"
                    search-action="company/branch/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="employmentStatus"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'employee.employment_status.employment_status'
                            ),
                        })
                    "
                    v-model="form.employmentStatus"
                    value-prop="uuid"
                    :init-search="fetchData.employmentStatus"
                    search-action="option/list"
                    :additional-search-query="{ type: 'employment_status' }"
                />
            </div>
            <div class="col-span-3 sm:col-span-1" v-if="dayWiseFilter">
                <BaseSwitch
                    vertical
                    v-model="form.dayWise"
                    name="dayWise"
                    :label="
                        $trans('global.report', {
                            attribute: $trans('attendance.day_wise'),
                        })
                    "
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive, inject, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const moment = inject("moment")

const emit = defineEmits(["hide"])

const props = defineProps({
    initUrl: {
        type: String,
        default: "",
    },
    dateAs: {
        type: String,
        default: "date",
    },
    dayWiseFilter: {
        type: Boolean,
        default: false,
    },
})

const initForm = {
    date: "",
    codeNumber: "",
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
    dayWise: false,
}

const form = reactive({ ...initForm })
const formErrors = getFormErrors(props.initUrl)

const fetchData = reactive({
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
    isLoaded:
        route.query.department ||
        route.query.designation ||
        route.query.branch ||
        route.query.employmentStatus
            ? false
            : true,
})

onMounted(async () => {
    fetchData.department = route.query.department
    fetchData.designation = route.query.designation
    fetchData.branch = route.query.branch
    fetchData.employmentStatus = route.query.employmentStatus
    fetchData.isLoaded = true
})
</script>
