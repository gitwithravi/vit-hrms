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
                label: $trans('attendance.work_shift.work_shift'),
                path: {
                    name: 'EmployeeWorkShift',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeWorkShift"
            :title="$trans('attendance.work_shift.work_shift')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <WorkShiftForm></WorkShiftForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeWorkShiftAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import WorkShiftForm from "./Form.vue"

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
