<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader :title="$trans('device.device')" :navs="[]">
                <PageHeaderAction
                    url="devices/"
                    name="Device"
                    :title="$trans('device.device')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                />
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="devices.headers"
                :meta="devices.meta"
                module="device"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="device in devices.data" :key="device.uuid">
                    <DataCell name="name">
                        {{ device.name }}
                    </DataCell>
                    <DataCell name="code">
                        {{ device.code }}
                    </DataCell>
                    <DataCell name="token">
                        {{ device.token }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ device.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'DeviceShow',
                                        params: { uuid: device.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'DeviceEdit',
                                        params: { uuid: device.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'DeviceDuplicate',
                                        params: { uuid: device.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: device.uuid,
                                    })
                                "
                                >{{
                                    $trans("general.delete")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton @click="router.push({ name: 'DeviceCreate' })">
                        {{
                            $trans("global.add", {
                                attribute: $trans("device.device"),
                            })
                        }}
                    </BaseButton>
                </template>
            </DataTable>
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "DeviceList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["create", "filter"]

let dropdownActions = ["print", "pdf", "excel"]

const initUrl = "device/"
const showFilter = ref(false)
const showImport = ref(false)

const devices = reactive({})

const setItems = (data) => {
    Object.assign(devices, data)
}
</script>
