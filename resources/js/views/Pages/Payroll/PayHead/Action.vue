<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('payroll.payroll'), path: 'Payroll' },
            {
                label: $trans('payroll.pay_head.pay_head'),
                path: 'PayrollPayHeadList',
            },
        ]"
    >
        <PageHeaderAction
            name="PayrollPayHead"
            :title="$trans('payroll.pay_head.pay_head')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <PayrollPayHeadForm></PayrollPayHeadForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollPayHeadAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import PayrollPayHeadForm from "./Form.vue"

const route = useRoute()
</script>
