<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('finance.payment_method.payment_method')"
                :navs="[{ label: $trans('finance.finance'), path: 'Finance' }]"
            >
                <PageHeaderAction
                    url="finance/payment-methods/"
                    name="FinancePaymentMethod"
                    :title="$trans('finance.payment_method.payment_method')"
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
                :header="paymentMethods.headers"
                :meta="paymentMethods.meta"
                module="finance.payment_method"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="paymentMethod in paymentMethods.data"
                    :key="paymentMethod.uuid"
                >
                    <DataCell name="name">
                        {{ paymentMethod.name }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ paymentMethod.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'FinancePaymentMethodShow',
                                        params: { uuid: paymentMethod.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'FinancePaymentMethodEdit',
                                        params: { uuid: paymentMethod.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'FinancePaymentMethodDuplicate',
                                        params: { uuid: paymentMethod.uuid },
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
                                        uuid: paymentMethod.uuid,
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
                        @click="
                            router.push({ name: 'FinancePaymentMethodCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "finance.payment_method.payment_method"
                                ),
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
    name: "FinancePaymentMethodList",
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

const initUrl = "finance/paymentMethod/"
const showFilter = ref(false)

const paymentMethods = reactive({})

const setItems = (data) => {
    Object.assign(paymentMethods, data)
}
</script>
