<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('company.company'), path: 'Company' },
            {
                label: $trans('company.department.department'),
                path: 'CompanyDepartmentList',
            },
        ]"
    >
        <PageHeaderAction
            name="CompanyDepartment"
            :title="$trans('company.department.department')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <DepartmentForm></DepartmentForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "CompanyDepartmentAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import DepartmentForm from "./Form.vue"

const route = useRoute()
</script>
