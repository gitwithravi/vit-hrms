<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('finance.finance'), path: 'Finance' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :init-url="initUrl"
            data-fetch="finance"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Finance"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3">
                    <BaseSwitch
                        reverse
                        v-model="form.enablePaypal"
                        name="enablePaypal"
                        :label="
                            $trans(
                                'finance.config.props.enable_payment_gateway',
                                { attribute: 'PayPal' }
                            )
                        "
                        v-model:error="formErrors.enablePaypal"
                    />
                </div>
                <template v-if="form.enablePaypal">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.paypalClient"
                            name="paypalClient"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_client',
                                    { attribute: 'PayPal' }
                                )
                            "
                            v-model:error="formErrors.paypalClient"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.paypalSecret"
                            name="paypalSecret"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_secret',
                                    { attribute: 'PayPal' }
                                )
                            "
                            v-model:error="formErrors.paypalSecret"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.paypalMode"
                            name="paypalMode"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_mode',
                                    { attribute: 'PayPal' }
                                )
                            "
                            v-model:error="formErrors.paypalMode"
                        />
                    </div>
                </template>
                <div class="col-span-3">
                    <BaseSwitch
                        reverse
                        v-model="form.enableStripe"
                        name="enableStripe"
                        :label="
                            $trans(
                                'finance.config.props.enable_payment_gateway',
                                { attribute: 'Stripe' }
                            )
                        "
                        v-model:error="formErrors.enableStripe"
                    />
                </div>
                <template v-if="form.enableStripe">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.stripeClient"
                            name="stripeClient"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_client',
                                    { attribute: 'Stripe' }
                                )
                            "
                            v-model:error="formErrors.stripeClient"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.stripeSecret"
                            name="stripeSecret"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_secret',
                                    { attribute: 'Stripe' }
                                )
                            "
                            v-model:error="formErrors.stripeSecret"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.stripeMode"
                            name="stripeMode"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_mode',
                                    { attribute: 'Stripe' }
                                )
                            "
                            v-model:error="formErrors.stripeMode"
                        />
                    </div>
                </template>
                <div class="col-span-3">
                    <BaseSwitch
                        reverse
                        v-model="form.enableRazorpay"
                        name="enableRazorpay"
                        :label="
                            $trans(
                                'finance.config.props.enable_payment_gateway',
                                { attribute: 'Razorpay' }
                            )
                        "
                        v-model:error="formErrors.enableRazorpay"
                    />
                </div>
                <template v-if="form.enableRazorpay">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.razorpayClient"
                            name="razorpayClient"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_client',
                                    { attribute: 'Razorpay' }
                                )
                            "
                            v-model:error="formErrors.razorpayClient"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.razorpaySecret"
                            name="razorpaySecret"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_secret',
                                    { attribute: 'Razorpay' }
                                )
                            "
                            v-model:error="formErrors.razorpaySecret"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.razorpayMode"
                            name="razorpayMode"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_mode',
                                    { attribute: 'Razorpay' }
                                )
                            "
                            v-model:error="formErrors.razorpayMode"
                        />
                    </div>
                </template>
                <div class="col-span-3">
                    <BaseSwitch
                        reverse
                        v-model="form.enableCcavenue"
                        name="enableCcavenue"
                        :label="
                            $trans(
                                'finance.config.props.enable_payment_gateway',
                                { attribute: 'CCAvenue' }
                            )
                        "
                        v-model:error="formErrors.enableCcavenue"
                    />
                </div>
                <template v-if="form.enableCcavenue">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.ccavenueMerchant"
                            name="ccavenueMerchant"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_merchant',
                                    { attribute: 'CCAvenue' }
                                )
                            "
                            v-model:error="formErrors.ccavenueMerchant"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.ccavenueClient"
                            name="ccavenueClient"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_client',
                                    { attribute: 'CCAvenue' }
                                )
                            "
                            v-model:error="formErrors.ccavenueClient"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.ccavenueSecret"
                            name="ccavenueSecret"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_secret',
                                    { attribute: 'CCAvenue' }
                                )
                            "
                            v-model:error="formErrors.ccavenueSecret"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSwitch
                            vertical
                            v-model="form.ccavenueMode"
                            name="ccavenueMode"
                            :label="
                                $trans(
                                    'finance.config.props.payment_gateway_mode',
                                    { attribute: 'CCAvenue' }
                                )
                            "
                            v-model:error="formErrors.ccavenueMode"
                        />
                    </div>
                </template>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "FinanceConfigInvoice",
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

const initForm = {
    enablePaypal: "",
    paypalMode: false,
    paypalClient: "",
    paypalSecret: "",
    enableStripe: "",
    stripeMode: false,
    stripeClient: "",
    stripeSecret: "",
    enableRazorpay: "",
    razorpayMode: false,
    razorpayClient: "",
    razorpaySecret: "",
    enableCcavenue: "",
    ccavenueMode: false,
    ccavenueMerchant: "",
    ccavenueClient: "",
    ccavenueSecret: "",
    type: "finance",
}

const form = reactive({ ...initForm })
</script>
