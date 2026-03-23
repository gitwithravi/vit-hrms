<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('payroll.payroll'), path: 'Payroll' }]"
    >
        <PageHeaderAction
            name="Payroll"
            :title="$trans('payroll.payroll')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <PayrollForm></PayrollForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import PayrollForm from "./Form.vue"

const route = useRoute()
</script>
