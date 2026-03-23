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
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'AttendanceTimesheet' })"
        >
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "AttendanceTimesheetShow",
}
</script>

<script setup>
import { reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const $trans = inject("$trans")

const initialTimesheet = {}

const initUrl = "attendance/timesheet/"

const timesheet = reactive({ ...initialTimesheet })

const setItem = (data) => {
    Object.assign(timesheet, data)
}
</script>
