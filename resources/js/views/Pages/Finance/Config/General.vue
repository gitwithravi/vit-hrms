<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('finance.finance'), path: 'Finance' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :pre-requisites="{ data: ['datePlaceholders'] }"
            @setPreRequisites="setPreRequisites"
            :init-url="initUrl"
            data-fetch="finance"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Finance"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.paymentNumberPrefix"
                        name="paymentNumberPrefix"
                        :label="
                            $trans('finance.config.props.payment_number_prefix')
                        "
                        v-model:error="formErrors.paymentNumberPrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="number"
                        v-model="form.paymentNumberDigit"
                        name="paymentNumberDigit"
                        :label="
                            $trans('finance.config.props.payment_number_digit')
                        "
                        v-model:error="formErrors.paymentNumberDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.paymentNumberSuffix"
                        name="paymentNumberSuffix"
                        :label="
                            $trans('finance.config.props.payment_number_suffix')
                        "
                        v-model:error="formErrors.paymentNumberSuffix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.receiptNumberPrefix"
                        name="receiptNumberPrefix"
                        :label="
                            $trans('finance.config.props.receipt_number_prefix')
                        "
                        v-model:error="formErrors.receiptNumberPrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="number"
                        v-model="form.receiptNumberDigit"
                        name="receiptNumberDigit"
                        :label="
                            $trans('finance.config.props.receipt_number_digit')
                        "
                        v-model:error="formErrors.receiptNumberDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.receiptNumberSuffix"
                        name="receiptNumberSuffix"
                        :label="
                            $trans('finance.config.props.receipt_number_suffix')
                        "
                        v-model:error="formErrors.receiptNumberSuffix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.transferNumberPrefix"
                        name="transferNumberPrefix"
                        :label="
                            $trans(
                                'finance.config.props.transfer_number_prefix'
                            )
                        "
                        v-model:error="formErrors.transferNumberPrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="number"
                        v-model="form.transferNumberDigit"
                        name="transferNumberDigit"
                        :label="
                            $trans('finance.config.props.transfer_number_digit')
                        "
                        v-model:error="formErrors.transferNumberDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.transferNumberSuffix"
                        name="transferNumberSuffix"
                        :label="
                            $trans(
                                'finance.config.props.transfer_number_suffix'
                            )
                        "
                        v-model:error="formErrors.transferNumberSuffix"
                    />
                </div>
                <div class="col-span-3">
                    <BaseAlert design="info">{{
                        datePlaceholderInfo
                    }}</BaseAlert>
                </div>

                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.enableBankCode1"
                        name="enableBankCode1"
                        :label="
                            $trans('global.enable', {
                                attribute: $trans(
                                    'finance.config.props.bank_code1'
                                ),
                            })
                        "
                        v-model:error="formErrors.enableBankCode1"
                    />
                </div>
                <template v-if="form.enableBankCode1">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.bankCode1Label"
                            name="bankCode1Label"
                            :label="
                                $trans('global.label', {
                                    attribute: $trans(
                                        'finance.config.props.bank_code1'
                                    ),
                                })
                            "
                            v-model:error="formErrors.bankCode1Label"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.isBankCode1Required"
                            name="bankCode1Required"
                            :label="
                                $trans('global.required', {
                                    attribute: $trans(
                                        'finance.config.props.bank_code1'
                                    ),
                                })
                            "
                            v-model:error="formErrors.isBankCode1Required"
                        />
                    </div>
                </template>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.enableBankCode2"
                        name="enableBankCode2"
                        :label="
                            $trans('global.enable', {
                                attribute: $trans(
                                    'finance.config.props.bank_code2'
                                ),
                            })
                        "
                        v-model:error="formErrors.enableBankCode2"
                    />
                </div>
                <template v-if="form.enableBankCode2">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.bankCode2Label"
                            name="bankCode2Label"
                            :label="
                                $trans('global.label', {
                                    attribute: $trans(
                                        'finance.config.props.bank_code2'
                                    ),
                                })
                            "
                            v-model:error="formErrors.bankCode2Label"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.isBankCode2Required"
                            name="bankCode2Required"
                            :label="
                                $trans('global.required', {
                                    attribute: $trans(
                                        'finance.config.props.bank_code2'
                                    ),
                                })
                            "
                            v-model:error="formErrors.isBankCode2Required"
                        />
                    </div>
                </template>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.enableBankCode3"
                        name="enableBankCode3"
                        :label="
                            $trans('global.enable', {
                                attribute: $trans(
                                    'finance.config.props.bank_code3'
                                ),
                            })
                        "
                        v-model:error="formErrors.enableBankCode3"
                    />
                </div>
                <template v-if="form.enableBankCode3">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.bankCode3Label"
                            name="bankCode3Label"
                            :label="
                                $trans('global.label', {
                                    attribute: $trans(
                                        'finance.config.props.bank_code3'
                                    ),
                                })
                            "
                            v-model:error="formErrors.bankCode3Label"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.isBankCode3Required"
                            name="bankCode3Required"
                            :label="
                                $trans('global.required', {
                                    attribute: $trans(
                                        'finance.config.props.bank_code2'
                                    ),
                                })
                            "
                            v-model:error="formErrors.isBankCode3Required"
                        />
                    </div>
                </template>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "FinanceConfigGeneral",
}
</script>

<script setup>
import { inject, reactive, computed } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const $trans = inject("$trans")

const initUrl = "config/"
const formErrors = getFormErrors(initUrl)
const datePlaceholderInfo = computed(() =>
    $trans("global.placeholder_info", {
        attribute: preRequisites.datePlaceholders,
    })
)

const preRequisites = reactive({
    datePlaceholders: "",
})

const initForm = {
    paymentNumberPrefix: "",
    paymentNumberDigit: "",
    paymentNumberSuffix: "",
    receiptNumberPrefix: "",
    receiptNumberDigit: "",
    receiptNumberSuffix: "",
    transferNumberPrefix: "",
    transferNumberDigit: "",
    transferNumberSuffix: "",
    enableBankCode1: true,
    enableBankCode2: true,
    enableBankCode3: true,
    bankCode1Label: "",
    bankCode2Label: "",
    bankCode3Label: "",
    isBankCode1Required: false,
    isBankCode2Required: false,
    isBankCode3Required: false,
    type: "finance",
}

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, {
        datePlaceholders: data.datePlaceholders
            .map((item) => item.value)
            .join(", "),
    })
}
</script>
