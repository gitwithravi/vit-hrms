<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('attendance.attendance'), path: 'Attendance' },
            {
                label: $trans('attendance.work_shift.work_shift'),
                path: 'AttendanceWorkShiftList',
            },
        ]"
    >
        <PageHeaderAction
            name="AttendanceWorkShift"
            :title="$trans('attendance.work_shift.work_shift')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <AttendanceWorkShiftForm></AttendanceWorkShiftForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "AttendanceWorkShiftAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import AttendanceWorkShiftForm from "./Form.vue"

const route = useRoute()
</script>
