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
                label: $trans('attendance.timesheet.timesheet'),
                path: 'AttendanceTimesheetList',
            },
        ]"
    >
        <PageHeaderAction
            name="AttendanceTimesheet"
            :title="$trans('attendance.timesheet.timesheet')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <TimesheetForm></TimesheetForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "AttendanceTimesheetAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import TimesheetForm from "./Form.vue"

const route = useRoute()
</script>
