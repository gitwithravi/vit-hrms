<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('leave.leave'), path: 'Leave' },
            {
                label: $trans('leave.request.request'),
                path: 'LeaveRequestList',
            },
        ]"
    >
        <PageHeaderAction
            name="LeaveRequest"
            :title="$trans('leave.request.request')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <LeaveRequestForm></LeaveRequestForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "LeaveRequestAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import LeaveRequestForm from "./Form.vue"

const route = useRoute()
</script>
