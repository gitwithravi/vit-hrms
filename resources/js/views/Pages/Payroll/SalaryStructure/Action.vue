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
                label: $trans('payroll.salary_structure.salary_structure'),
                path: 'PayrollSalaryStructureList',
            },
        ]"
    >
        <PageHeaderAction
            name="PayrollSalaryStructure"
            :title="$trans('payroll.salary_structure.salary_structure')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <PayrollSalaryStructureForm></PayrollSalaryStructureForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollSalaryStructureAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import PayrollSalaryStructureForm from "./Form.vue"

const route = useRoute()
</script>
