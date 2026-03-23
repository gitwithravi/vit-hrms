<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="FinanceLedger"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('finance.ledger.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('finance.ledger.props.alias')"
                    v-model:error="formErrors.alias"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    name="type"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'finance.ledger_type.ledger_type'
                            ),
                        })
                    "
                    :options="preRequisites.ledgerTypes"
                    :object-prop="true"
                    v-model="state.selectedLedgerType"
                    v-model:error="formErrors.type"
                    @change="ledgerTypeSelected"
                    label-prop="name"
                    value-prop="uuid"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    v-model="form.openingBalance"
                    name="openingBalance"
                    :label="$trans('finance.ledger.props.opening_balance')"
                    v-model:error="formErrors.openingBalance"
                    currency
                />
            </div>
            <div class="col-span-3 sm:col-span-2">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('finance.ledger.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>

        <!-- <BaseFieldset
            class="mt-4"
            v-if="state.selectedLedgerType.hasCodeNumber"
        >
            <template #legend>{{
                $trans("finance.account.number_info")
            }}</template>
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codePrefix"
                        name="codePrefix"
                        :label="$trans('finance.ledger.props.code_prefix')"
                        v-model:error="formErrors.codePrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeDigit"
                        name="codeDigit"
                        :label="$trans('finance.ledger.props.code_digit')"
                        v-model:error="formErrors.codeDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeSuffix"
                        name="codeSuffix"
                        :label="$trans('finance.ledger.props.code_suffix')"
                        v-model:error="formErrors.codeSuffix"
                    />
                </div>
            </div>
        </BaseFieldset> -->

        <BaseFieldset class="mt-4" v-if="state.selectedLedgerType.hasAccount">
            <template #legend>{{ $trans("finance.account.info") }}</template>
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.account.name"
                        name="accountName"
                        :label="$trans('finance.account.props.name')"
                        v-model:error="formErrors.accountName"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.account.number"
                        name="accountNumber"
                        :label="$trans('finance.account.props.number')"
                        v-model:error="formErrors.accountNumber"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.account.bankName"
                        name="accountBankName"
                        :label="$trans('finance.account.props.bank_name')"
                        v-model:error="formErrors.accountBankName"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.account.branchName"
                        name="accountBranchName"
                        :label="$trans('finance.account.props.branch_name')"
                        v-model:error="formErrors.accountBranchName"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.account.branchAddress"
                        name="accountBranchAddress"
                        :label="$trans('finance.account.props.branch_address')"
                        v-model:error="formErrors.accountBranchAddress"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.account.branchCode"
                        name="accountBranchCode"
                        :label="$trans('finance.account.props.branch_code')"
                        v-model:error="formErrors.accountBranchCode"
                    />
                </div>
            </div>
        </BaseFieldset>

        <BaseFieldset class="mt-4" v-if="state.selectedLedgerType.hasContact">
            <template #legend>{{ $trans("contact.info") }}</template>
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.contactNumber"
                        name="contactNumber"
                        :label="$trans('finance.ledger.props.contact_number')"
                        v-model:error="formErrors.contactNumber"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.email"
                        name="email"
                        :label="$trans('finance.ledger.props.email')"
                        v-model:error="formErrors.email"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1"></div>
                <AddressInput
                    v-model:addressLine1="form.address.addressLine1"
                    v-model:addressLine2="form.address.addressLine2"
                    v-model:city="form.address.city"
                    v-model:state="form.address.state"
                    v-model:zipcode="form.address.zipcode"
                    v-model:country="form.address.country"
                    v-model:formErrors="formErrors"
                />
            </div>
        </BaseFieldset>
    </FormAction>
</template>

<script>
export default {
    name: "FinanceLedgerForm",
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
    type: "",
    openingBalance: "",
    description: "",
    contactNumber: "",
    email: "",
    codePrefix: "",
    codeDigit: "",
    codeSuffix: "",
    address: {
        addressLine1: "",
        addressLine2: "",
        city: "",
        state: "",
        zipcode: "",
        country: "",
    },
    account: {
        name: "",
        number: "",
        bankName: "",
        branchName: "",
        branchAddress: "",
        branchCode: "",
    },
}

const initUrl = "finance/ledger/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    ledgerTypes: [],
})

const state = reactive({
    selectedLedgerType: {},
})
const form = reactive({ ...initForm })
const fetchData = reactive({
    type: "",
    isLoaded: route.params.uuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    Object.assign(form, cloneDeep(initForm))
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        openingBalance: data.openingBalance.value,
        type: data.type?.uuid || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.type = data.type?.uuid || ""
    state.selectedLedgerType = data.type
    fetchData.isLoaded = true
}

const ledgerTypeSelected = (data) => {
    form.type = data.uuid || ""
}
</script>
