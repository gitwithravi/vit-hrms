<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('payroll.pay_head.pay_head')"
                :navs="[{ label: $trans('payroll.payroll'), path: 'Payroll' }]"
            >
                <PageHeaderAction
                    url="payroll/pay-heads/"
                    name="PayrollPayHead"
                    :title="$trans('payroll.pay_head.pay_head')"
                    :actions="userActions"
                    :dropdown-actions="['print', 'pdf', 'excel']"
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
                :header="payHeads.headers"
                :meta="payHeads.meta"
                module="payroll.pay_head"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="payHead in payHeads.data" :key="payHead.uuid">
                    <DataCell name="name">
                        {{ payHead.name }}
                    </DataCell>
                    <DataCell name="code">
                        {{ payHead.code }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ payHead.alias }}
                    </DataCell>
                    <DataCell name="category">
                        {{ payHead.category.label }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ payHead.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'PayrollPayHeadShow',
                                        params: { uuid: payHead.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'PayrollPayHeadEdit',
                                        params: { uuid: payHead.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'PayrollPayHeadDuplicate',
                                        params: { uuid: payHead.uuid },
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
                                        uuid: payHead.uuid,
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
                    <BaseButton
                        @click="router.push({ name: 'PayrollPayHeadCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("payroll.pay_head.pay_head"),
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
    name: "PayrollPayHeadList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["create", "filter"]

const initUrl = "payroll/payHead/"
const showFilter = ref(false)

const payHeads = reactive({})

const setItems = (data) => {
    Object.assign(payHeads, data)
}
</script>
