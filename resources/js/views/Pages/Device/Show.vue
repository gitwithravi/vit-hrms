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
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'Device' })"
        >
            <BaseCard v-if="device.uuid">
                <template #title>
                    {{ device.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('device.props.name')">
                        {{ device.name }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('device.props.code')">
                        {{ device.code }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('device.props.description')"
                    >
                        <div v-html="device.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ device.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ device.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            @click="
                                router.push({
                                    name: 'DeviceEdit',
                                    params: { uuid: device.uuid },
                                })
                            "
                        >
                            {{ $trans("general.edit") }}
                        </BaseButton>
                    </ShowButton>
                </template>
            </BaseCard>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "DeviceShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialDevice = {}

const initUrl = "device/"

const device = reactive({ ...initialDevice })

const setItem = (data) => {
    Object.assign(device, data)
}
</script>
