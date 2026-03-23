<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('employee.employee'), path: 'EmployeeList' }]"
    >
        <PageHeaderAction
            name="Employee"
            :title="$trans('employee.employee')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <EmployeeForm></EmployeeForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import EmployeeForm from "./Form.vue"

const route = useRoute()
</script>
