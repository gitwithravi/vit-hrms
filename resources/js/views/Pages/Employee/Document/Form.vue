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
            name: 'EmployeeDocument',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.type"
                    name="type"
                    :label="$trans('employee.document_type.document_type')"
                    label-prop="name"
                    value-prop="uuid"
                    :options="preRequisites.types"
                    v-model:error="formErrors.type"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.title"
                    name="title"
                    :label="$trans('employee.document.props.title')"
                    v-model:error="formErrors.title"
                    autofocus
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.startDate"
                    name="startDate"
                    :label="$trans('employee.document.props.start_date')"
                    v-model:error="formErrors.startDate"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.endDate"
                    name="endDate"
                    :label="$trans('employee.document.props.end_date')"
                    v-model:error="formErrors.endDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-2">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('employee.document.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="document"
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
    name: "EmployeeDocumentForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    type: "",
    title: "",
    description: "",
    startDate: "",
    endDate: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "employee/document/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    types: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    type: "",
    isLoaded: route.params.muuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        type: data.type?.uuid,
        startDate: data.startDate?.value || "",
        endDate: data.endDate?.value || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.type = data.type.name
    fetchData.isLoaded = true
}
</script>
