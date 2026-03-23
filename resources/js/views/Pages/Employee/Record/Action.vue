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
                label: $trans('employee.record.record'),
                path: {
                    name: 'EmployeeRecord',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeRecord"
            :title="$trans('employee.record.record')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <RecordForm :employee="employee"></RecordForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeRecordAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import RecordForm from "./Form.vue"

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
