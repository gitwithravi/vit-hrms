<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="AttendanceType"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.category"
                    name="category"
                    :label="$trans('attendance.type.props.category')"
                    :options="preRequisites.attendanceCategories"
                    v-model:error="formErrors.category"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('attendance.type.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('attendance.type.props.alias')"
                    v-model:error="formErrors.alias"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('attendance.type.props.code')"
                    v-model:error="formErrors.code"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-2">
                <SelectedColorPicker
                    v-model="form.color"
                    :label="$trans('general.color')"
                    v-model:error="formErrors.color"
                />
            </div>
            <div class="col-span-3">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('attendance.type.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "AttendanceTypeForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
    code: "",
    color: "",
    category: "",
    alias: "",
    description: "",
}

const initUrl = "attendance/type/"
const preRequisites = reactive({
    attendanceCategories: [],
})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        category: data.category?.value,
    })
    Object.assign(form, cloneDeep(initForm))
}
</script>
