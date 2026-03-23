<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('employee.employee'), path: 'EmployeeList' },
            {
                label: employee.contact.name,
                path: {
                    name: 'EmployeeShow',
                    params: { uuid: employee.uuid },
                },
            },
            {
                label: $trans('finance.account.account'),
                path: {
                    name: 'EmployeeAccount',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeAccount"
            :title="$trans('finance.account.account')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <AccountForm></AccountForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeAccountAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import AccountForm from "./Form.vue"

const route = useRoute()

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})
</script>
