<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('calendar.calendar'), path: 'Calendar' },
            {
                label: $trans('calendar.holiday.holiday'),
                path: 'CalendarHolidayList',
            },
        ]"
    >
        <PageHeaderAction
            name="CalendarHoliday"
            :title="$trans('calendar.holiday.holiday')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <HolidayForm></HolidayForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "CalendarHolidayAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import HolidayForm from "./Form.vue"

const route = useRoute()
</script>
