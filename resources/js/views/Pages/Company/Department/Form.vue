<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        redirect="CompanyDepartment"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('company.department.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('company.department.props.alias')"
                    v-model:error="formErrors.alias"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('company.department.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "CompanyDepartmentForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { getFormErrors } from "@core/helpers/action"

const initForm = {
    name: "",
    alias: "",
    description: "",
}

const initUrl = "company/department/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
</script>
