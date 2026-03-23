<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="Employee"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3">
                <BaseRadioGroup
                    top-margin
                    :options="preRequisites.employeeTypes"
                    name="employeeType"
                    v-model="form.employeeType"
                    v-model:error="formErrors.employeeType"
                    horizontal
                />
            </div>

            <template v-if="form.employeeType == 'existing'">
                <div class="col-span-3">
                    <BaseSelectSearch
                        name="employee"
                        :label="
                            $trans('global.select', {
                                attribute: $trans('employee.employee'),
                            })
                        "
                        v-model="form.employee"
                        v-model:error="formErrors.employee"
                        value-prop="uuid"
                        search-action="employee/list"
                    >
                        <template #selectedOption="slotProps">
                            {{ slotProps.value.contact.name }} ({{
                                slotProps.value.contact.contactNumber
                            }})
                        </template>

                        <template #listOption="slotProps">
                            {{ slotProps.option.contact.name }} ({{
                                slotProps.option.contact.contactNumber
                            }})
                        </template>
                    </BaseSelectSearch>
                </div>
            </template>

            <template v-if="form.employeeType == 'new'">
                <div class="col-span-3 sm:col-span-2">
                    <BaseLabel>{{ $trans("employee.props.name") }}</BaseLabel>
                    <div class="flex">
                        <NameInput
                            v-model:firstName="form.firstName"
                            v-model:middleName="form.middleName"
                            v-model:thirdName="form.thirdName"
                            v-model:lastName="form.lastName"
                            v-model:formErrors="formErrors"
                        />
                    </div>
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseLabel>{{ $trans("contact.props.gender") }}</BaseLabel>
                    <BaseRadioGroup
                        top-margin
                        :options="preRequisites.genders"
                        name="gender"
                        v-model="form.gender"
                        v-model:error="formErrors.gender"
                        horizontal
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <DatePicker
                        v-model="form.birthDate"
                        name="birthDate"
                        :label="$trans('contact.props.birth_date')"
                        no-clear
                        v-model:error="formErrors.birthDate"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.contactNumber"
                        name="contactNumber"
                        :label="$trans('contact.props.contact_number')"
                        v-model:error="formErrors.contactNumber"
                        autofocus
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.email"
                        name="email"
                        :label="$trans('contact.props.email')"
                        v-model:error="formErrors.email"
                        autofocus
                    />
                </div>
            </template>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.codeNumber"
                    name="codeNumber"
                    :label="$trans('employee.props.code_number')"
                    v-model:error="formErrors.codeNumber"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.joiningDate"
                    name="joiningDate"
                    :label="$trans('employee.props.joining_date')"
                    no-clear
                    v-model:error="formErrors.joiningDate"
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
                    v-model:error="formErrors.employmentStatus"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.employmentStatus"
                    @change=""
                    search-action="option/list"
                    :additional-search-query="{ type: 'employment_status' }"
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
                    v-model:error="formErrors.department"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.department"
                    @change=""
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
                    v-model:error="formErrors.designation"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.designation"
                    @change=""
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
                    v-model:error="formErrors.branch"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.branch"
                    @change=""
                    search-action="company/branch/list"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "EmployeeForm",
}
</script>

<script setup>
import { reactive, computed, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"
import { confirmDelete } from "@core/helpers/alert"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initForm = {
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
    joiningDate: "",
    codeNumber: "",
    employeeType: "new",
    firstName: "",
    middleName: "",
    thirdName: "",
    lastName: "",
    birthDate: "",
    gender: "",
    contactNumber: "",
    email: "",
}

const initUrl = "employee/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    genders: [],
    employeeTypes: [],
    codeNumber: "",
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
    isLoaded: route.params.uuid ? false : true,
})

const setForm = (data) => {
    Object.assign(form, data)

    fetchData.department = data.department.name
    fetchData.designation = data.designation.name
    fetchData.branch = data.branch.name
    fetchData.employmentStatus = data.employmentStatus.name
    fetchData.isLoaded = true
}

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    initForm.codeNumber = data.codeNumber
    Object.assign(form, cloneDeep(initForm))
}
</script>
