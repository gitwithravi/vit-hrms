<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        redirect="LeaveType"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('leave.type.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('leave.type.props.code')"
                    v-model:error="formErrors.code"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('leave.type.props.alias')"
                    v-model:error="formErrors.alias"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('leave.type.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "LeaveTypeForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
    code: "",
    alias: "",
    description: "",
}

const initUrl = "leave/type/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
</script>
