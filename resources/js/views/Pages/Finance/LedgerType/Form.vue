<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="FinanceLedgerType"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('finance.ledger_type.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('finance.ledger_type.props.alias')"
                    v-model:error="formErrors.alias"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.parent"
                    name="parent"
                    :label="$trans('finance.ledger_type.props.parent')"
                    :options="preRequisites.types"
                    label-prop="name"
                    value-prop="uuid"
                    v-model:error="formErrors.parent"
                />
            </div>
            <div class="col-span-3">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('finance.ledger_type.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "FinanceLedgerTypeForm",
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
    alias: "",
    parent: "",
    description: "",
}

const initUrl = "finance/ledgerType/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    types: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    isLoaded: route.params.uuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        parent: data.parent?.uuid || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.isLoaded = true
}
</script>
