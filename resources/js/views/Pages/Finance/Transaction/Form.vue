<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="FinanceTransaction"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2">
                <CustomCheckbox
                    :disabled="route.params.uuid ? true : false"
                    :label="$trans('finance.transaction.props.type')"
                    :options="preRequisites.types"
                    v-model="form.type"
                    v-model:error="formErrors.type"
                />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.primaryLedger"
                    name="primaryLedger"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('finance.ledger.ledger'),
                        })
                    "
                    :object-prop="true"
                    label-prop="name"
                    value-prop="uuid"
                    :options="preRequisites.primaryLedgers"
                    v-model:error="formErrors.primaryLedger"
                />
                <LedgerBalance :label="true" :ledger="form.primaryLedger" />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model="form.date"
                    name="date"
                    :label="$trans('finance.transaction.props.date')"
                    no-clear
                    v-model:error="formErrors.date"
                />
            </div>
        </div>

        <div
            class="mt-4 grid grid-cols-3 gap-6"
            v-for="(record, index) in form.records"
        >
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    :name="`records.${index}.secondaryLedger`"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'finance.ledger.secondary_ledger'
                            ),
                        })
                    "
                    v-model="record.secondaryLedger"
                    v-model:error="
                        formErrors[`records.${index}.secondaryLedger.uuid`]
                    "
                    :object-prop="true"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.secondaryLedger"
                    search-action="finance/ledger/list"
                    :additional-search-query="{
                        subType:
                            form.type == 'transfer' ? 'primary' : 'secondary',
                    }"
                />
                <LedgerBalance :label="true" :ledger="record.secondaryLedger" />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    currency
                    type="text"
                    v-model="record.amount"
                    :name="`records.${index}.amount`"
                    :label="$trans('finance.transaction.props.amount')"
                    v-model:error="formErrors[`records.${index}.amount`]"
                />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.paymentMethod"
                    name="paymentMethod"
                    :label="$trans('finance.payment_method.payment_method')"
                    label-prop="name"
                    value-prop="uuid"
                    :options="preRequisites.paymentMethods"
                    v-model:error="formErrors.paymentMethod"
                />
            </div>
            <PaymentMethodInput
                :selected-payment-method="selectedPaymentMethod"
                v-model:instrumentNumber="form.instrumentNumber"
                v-model:instrumentDate="form.instrumentDate"
                v-model:clearingDate="form.clearingDate"
                v-model:bankDetail="form.bankDetail"
                v-model:referenceNumber="form.referenceNumber"
                v-model:formErrors="formErrors"
            />
            <div class="col-span-3">
                <BaseTextarea
                    v-model="form.remarks"
                    name="remarks"
                    :label="$trans('finance.transaction.props.remarks')"
                    v-model:error="formErrors.remarks"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    :media-token="route.params.uuid ? form.mediaToken : ''"
                    multiple
                    :label="$trans('general.file')"
                    module="transaction"
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
    name: "FinanceTransactionForm",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    type: "",
    primaryLedger: {},
    date: "",
    records: [
        {
            secondaryLedger: {},
            amount: "",
        },
    ],
    paymentMethod: "",
    instrumentNumber: "",
    instrumentDate: "",
    clearingDate: "",
    bankDetail: "",
    referenceNumber: "",
    remarks: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "finance/transaction/"
const formErrors = getFormErrors(initUrl)

const selectedPaymentMethod = computed(() => {
    if (!form.paymentMethod) {
        return {}
    }

    return preRequisites.paymentMethods.find(
        (paymentMethod) => paymentMethod.uuid === form.paymentMethod
    )
})

const preRequisites = reactive({
    types: [],
    paymentMethods: [],
    primaryLedgers: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    primaryLedger: "",
    secondaryLedger: "",
    isLoaded: route.params.uuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    Object.assign(form, cloneDeep(initForm))
}

const setForm = (data) => {
    let records = []
    data.records.forEach((record) => {
        records.push({
            secondaryLedger: record.ledger,
            amount: record.amount.value,
        })
    })

    let payment = data.payments[0] || {}

    Object.assign(initForm, {
        ...data,
        records,
        type: data.type.value,
        primaryLedger: payment?.ledger,
        paymentMethod: payment?.methodUuid,
        date: data.date.value,
        instrumentNumber: payment.instrumentNumber || "",
        instrumentDate: payment.instrumentDate?.value || "",
        clearingDate: payment.clearingDate?.value || "",
        bankDetail: payment.bankDetail || "",
        referenceNumber: payment.referenceNumber || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.isLoaded = true
}
</script>
