<template>
    <FormAction
        :pre-requisites="false"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="FinancePaymentMethod"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('finance.payment_method.props.name')"
                    v-model:error="formErrors.name"
                />
            </div>
            <!-- <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.isPaymentGateway"
                    name="isPaymentGateway"
                    :label="
                        $trans(
                            'finance.payment_method.props.is_payment_gateway'
                        )
                    "
                    v-model:error="formErrors.isPaymentGateway"
                />
            </div> -->
            <div class="col-span-3 sm:col-span-1" v-if="form.isPaymentGateway">
                <BaseInput
                    type="text"
                    v-model="form.paymentGatewayName"
                    name="paymentGatewayName"
                    :label="
                        $trans(
                            'finance.payment_method.props.payment_gateway_name'
                        )
                    "
                    v-model:error="formErrors.paymentGatewayName"
                />
            </div>
        </div>
        <div class="mt-6 grid grid-cols-3 gap-6" v-if="!form.isPaymentGateway">
            <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.hasInstrumentNumber"
                    name="hasInstrumentNumber"
                    :label="
                        $trans(
                            'finance.payment_method.props.has_instrument_number'
                        )
                    "
                    v-model:error="formErrors.hasInstrumentNumber"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.hasInstrumentDate"
                    name="hasInstrumentDate"
                    :label="
                        $trans(
                            'finance.payment_method.props.has_instrument_date'
                        )
                    "
                    v-model:error="formErrors.hasInstrumentDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.hasClearingDate"
                    name="hasClearingDate"
                    :label="
                        $trans('finance.payment_method.props.has_clearing_date')
                    "
                    v-model:error="formErrors.hasClearingDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.hasBankDetail"
                    name="hasBankDetail"
                    :label="
                        $trans('finance.payment_method.props.has_bank_detail')
                    "
                    v-model:error="formErrors.hasBankDetail"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.hasReferenceNumber"
                    name="hasReferenceNumber"
                    :label="
                        $trans(
                            'finance.payment_method.props.has_reference_number'
                        )
                    "
                    v-model:error="formErrors.hasReferenceNumber"
                />
            </div>
            <div class="col-span-3">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('finance.payment_method.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "FinancePaymentMethodForm",
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
    hasInstrumentDate: false,
    hasInstrumentNumber: false,
    hasClearingDate: false,
    hasBankDetail: false,
    hasReferenceNumber: false,
    isPaymentGateway: false,
    paymentGatewayName: "",
    description: "",
}

const initUrl = "finance/paymentMethod/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({})

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
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.isLoaded = true
}
</script>
