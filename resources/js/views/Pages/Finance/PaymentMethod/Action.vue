<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('finance.finance'), path: 'Finance' },
            {
                label: $trans('finance.payment_method.payment_method'),
                path: 'FinancePaymentMethodList',
            },
        ]"
    >
        <PageHeaderAction
            name="FinancePaymentMethod"
            :title="$trans('finance.payment_method.payment_method')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <PaymentMethodForm></PaymentMethodForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "FinancePaymentMethodAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import PaymentMethodForm from "./Form.vue"

const route = useRoute()
</script>
