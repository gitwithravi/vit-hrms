<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.codeNumber"
                    name="codeNumber"
                    :label="$trans('employee.props.code_number')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('contact.props.name')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model:start="form.joiningStartDate"
                    v-model:end="form.joiningEndDate"
                    name="joiningDateBetween"
                    as="range"
                    :label="
                        $trans('global.date_between', {
                            attribute: $trans('employee.props.joining_date'),
                        })
                    "
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model:start="form.leavingStartDate"
                    v-model:end="form.leavingEndDate"
                    name="leavingDateBetween"
                    as="range"
                    :label="
                        $trans('global.date_between', {
                            attribute: $trans('employee.props.leaving_date'),
                        })
                    "
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
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()

const emit = defineEmits(["hide"])

const initForm = {
    codeNumber: "",
    name: "",
    joiningStartDate: "",
    joiningEndDate: "",
    leavingStartDate: "",
    leavingEndDate: "",
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
}

const form = reactive({ ...initForm })

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
