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
                label: $trans('attendance.type.type'),
                path: 'AttendanceTypeList',
            },
        ]"
    >
        <PageHeaderAction
            name="AttendanceType"
            :title="$trans('attendance.type.type')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <AttendanceTypeForm></AttendanceTypeForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "AttendanceTypeAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import AttendanceTypeForm from "./Form.vue"

const route = useRoute()
</script>
