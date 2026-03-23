<template>
    <FormAction
        no-data-fetch
        :init-url="initUrl"
        :uuid="route.params.uuid"
        :module-uuid="route.params.muuid"
        :init-form="initForm"
        :form="form"
        :redirect="{
            name: 'EmployeeAccount',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('finance.account.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('finance.account.props.alias')"
                    v-model:error="formErrors.alias"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.number"
                    name="number"
                    :label="$trans('finance.account.props.number')"
                    v-model:error="formErrors.number"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.bankName"
                    name="bankName"
                    :label="$trans('finance.account.props.bank_name')"
                    v-model:error="formErrors.bankName"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.branchName"
                    name="branchName"
                    :label="$trans('finance.account.props.branch_name')"
                    v-model:error="formErrors.branchName"
                />
            </div>
            <div class="col-span-3 sm:col-span-1" v-if="enableBankCode1">
                <BaseInput
                    type="text"
                    v-model="form.bankCode1"
                    name="bankCode1"
                    :label="bankCode1Label"
                    v-model:error="formErrors.bankCode1"
                />
            </div>
            <div class="col-span-3 sm:col-span-1" v-if="enableBankCode2">
                <BaseInput
                    type="text"
                    v-model="form.bankCode2"
                    name="bankCode2"
                    :label="bankCode2Label"
                    v-model:error="formErrors.bankCode2"
                />
            </div>
            <div class="col-span-3 sm:col-span-1" v-if="enableBankCode3">
                <BaseInput
                    type="text"
                    v-model="form.bankCode3"
                    name="bankCode3"
                    :label="bankCode3Label"
                    v-model:error="formErrors.bankCode3"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="account"
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
    name: "EmployeeAccountForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors, getConfig } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
    alias: "",
    number: "",
    bankName: "",
    branchName: "",
    bankCode1: "",
    bankCode2: "",
    bankCode3: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "employee/account/"
const formErrors = getFormErrors(initUrl)
const enableBankCode1 = getConfig("finance.enableBankCode1")
const enableBankCode2 = getConfig("finance.enableBankCode2")
const enableBankCode3 = getConfig("finance.enableBankCode3")
const bankCode1Label = getConfig("finance.bankCode1Label")
const bankCode2Label = getConfig("finance.bankCode2Label")
const bankCode3Label = getConfig("finance.bankCode3Label")

const form = reactive({ ...initForm })
</script>
