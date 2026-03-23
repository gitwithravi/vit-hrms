<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('leave.leave'), path: 'Leave' },
            { label: $trans('leave.type.type'), path: 'LeaveTypeList' },
        ]"
    >
        <PageHeaderAction
            name="LeaveType"
            :title="$trans('leave.type.type')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <LeaveTypeForm></LeaveTypeForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "LeaveTypeAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import LeaveTypeForm from "./Form.vue"

const route = useRoute()
</script>
