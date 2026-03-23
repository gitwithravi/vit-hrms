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
            name: 'EmployeeQualification',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.level"
                    name="level"
                    :label="
                        $trans(
                            'employee.qualification_level.qualification_level'
                        )
                    "
                    label-prop="name"
                    value-prop="uuid"
                    :options="preRequisites.levels"
                    v-model:error="formErrors.level"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.course"
                    name="course"
                    :label="$trans('employee.qualification.props.course')"
                    v-model:error="formErrors.course"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.institute"
                    name="institute"
                    :label="$trans('employee.qualification.props.institute')"
                    v-model:error="formErrors.institute"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.affiliatedTo"
                    name="affiliatedTo"
                    :label="
                        $trans('employee.qualification.props.affiliated_to')
                    "
                    v-model:error="formErrors.affiliatedTo"
                    autofocus
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.startDate"
                    name="startDate"
                    :label="$trans('employee.qualification.props.start_date')"
                    v-model:error="formErrors.startDate"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.endDate"
                    name="endDate"
                    :label="$trans('employee.qualification.props.end_date')"
                    v-model:error="formErrors.endDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.result"
                    name="result"
                    :label="$trans('employee.qualification.props.result')"
                    v-model:error="formErrors.result"
                    autofocus
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="qualification"
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
    name: "EmployeeQualificationForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    level: "",
    course: "",
    institute: "",
    affiliatedTo: "",
    startDate: "",
    endDate: "",
    result: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "employee/qualification/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    levels: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    level: "",
    isLoaded: route.params.muuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        level: data.level?.uuid,
        startDate: data.startDate?.value || "",
        endDate: data.endDate?.value || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.level = data.level.name
    fetchData.isLoaded = true
}
</script>
