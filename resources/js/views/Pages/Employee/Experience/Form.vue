<template>
    <FormAction
        no-data-fetch
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :uuid="route.params.uuid"
        :module-uuid="route.params.muuid"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        :redirect="{
            name: 'EmployeeExperience',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.employmentType"
                    name="employmentType"
                    :label="$trans('employee.employment_type.employment_type')"
                    label-prop="name"
                    value-prop="uuid"
                    :options="preRequisites.employmentTypes"
                    v-model:error="formErrors.employmentType"
                />
            </div>
            <div class="col-span-3 sm:col-span-2">
                <BaseInput
                    type="text"
                    v-model="form.headline"
                    name="headline"
                    :label="$trans('employee.experience.props.headline')"
                    v-model:error="formErrors.headline"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.title"
                    name="title"
                    :label="$trans('employee.experience.props.title')"
                    v-model:error="formErrors.title"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.organizationName"
                    name="organizationName"
                    :label="
                        $trans('employee.experience.props.organization_name')
                    "
                    v-model:error="formErrors.organizationName"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.location"
                    name="location"
                    :label="$trans('employee.experience.props.location')"
                    v-model:error="formErrors.location"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.startDate"
                    name="startDate"
                    :label="$trans('employee.experience.props.start_date')"
                    v-model:error="formErrors.startDate"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.endDate"
                    name="endDate"
                    :label="$trans('employee.experience.props.end_date')"
                    v-model:error="formErrors.endDate"
                />
            </div>
            <div class="col-span-3">
                <BaseTextarea
                    v-model="form.jobProfile"
                    name="jobProfile"
                    :label="$trans('employee.experience.props.job_profile')"
                    v-model:error="formErrors.jobProfile"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="experience"
                    :media="form.media"
                    @setHash="(hash) => (form.mediaHash = hash)"
                    @setToken="(token) => (form.mediaToken = token)"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "EmployeeExperienceForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    employmentType: "",
    headline: "",
    title: "",
    organizationName: "",
    location: "",
    startDate: "",
    endDate: "",
    jobProfile: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "employee/experience/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    employmentTypes: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    employmentType: "",
    isLoaded: route.params.muuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        employmentType: data.employmentType?.uuid,
        startDate: data.startDate?.value || "",
        endDate: data.endDate?.value || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.employmentType = data.employmentType.name
    fetchData.isLoaded = true
}
</script>
