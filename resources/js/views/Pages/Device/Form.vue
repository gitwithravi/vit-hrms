<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        redirect="Device"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('device.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('device.props.code')"
                    v-model:error="formErrors.code"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('device.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "DeviceForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { getFormErrors } from "@core/helpers/action"

const initForm = {
    name: "",
    code: "",
    description: "",
}

const initUrl = "device/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
</script>
