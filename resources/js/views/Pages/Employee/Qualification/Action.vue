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
                label: $trans('employee.qualification.qualification'),
                path: {
                    name: 'EmployeeQualification',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeQualification"
            :title="$trans('employee.qualification.qualification')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <QualificationForm></QualificationForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeQualificationAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import QualificationForm from "./Form.vue"

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
