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
                label: $trans('payroll.salary_template.salary_template'),
                path: 'PayrollSalaryTemplateList',
            },
        ]"
    >
        <PageHeaderAction
            name="PayrollSalaryTemplate"
            :title="$trans('payroll.salary_template.salary_template')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <PayrollSalaryTemplateForm></PayrollSalaryTemplateForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollSalaryTemplateAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import PayrollSalaryTemplateForm from "./Form.vue"

const route = useRoute()
</script>
