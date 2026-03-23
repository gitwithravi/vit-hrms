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
                label: $trans('leave.allocation.allocation'),
                path: 'LeaveAllocationList',
            },
        ]"
    >
        <PageHeaderAction
            name="LeaveAllocation"
            :title="$trans('leave.allocation.allocation')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <LeaveAllocationForm></LeaveAllocationForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "LeaveAllocationAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import LeaveAllocationForm from "./Form.vue"

const route = useRoute()
</script>
