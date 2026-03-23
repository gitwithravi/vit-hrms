<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="PayrollPayHead"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.category"
                    name="category"
                    :label="$trans('payroll.pay_head.props.category')"
                    :options="preRequisites.payHeadCategories"
                    v-model:error="formErrors.category"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('payroll.pay_head.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('payroll.pay_head.props.code')"
                    v-model:error="formErrors.code"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('payroll.pay_head.props.alias')"
                    v-model:error="formErrors.alias"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('payroll.pay_head.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "PayrollPayHeadForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    category: "",
    name: "",
    code: "",
    alias: "",
    description: "",
}

const initUrl = "payroll/payHead/"
const preRequisites = reactive({
    payHeadCategories: [],
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
