<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('device.device'), path: 'Device' }]"
    >
        <PageHeaderAction
            name="Device"
            :title="$trans('device.device')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <DeviceForm></DeviceForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "DeviceAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import DeviceForm from "./Form.vue"

const route = useRoute()
</script>
