<template>
    <ListItem
        :init-url="initUrl"
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                :title="$trans('finance.transaction.transaction')"
                :navs="[{ label: $trans('finance.finance'), path: 'Finance' }]"
            >
                <PageHeaderAction
                    url="finance/transactions/"
                    name="FinanceTransaction"
                    :title="$trans('finance.transaction.transaction')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                >
                    <template #after>
                        <BaseButton
                            v-if="perform('finance:config')"
                            design="white"
                            @click="router.push({ name: 'FinanceConfig' })"
                        >
                            <i class="fas fa-cog"></i>
                        </BaseButton>
                    </template>
                </PageHeaderAction>
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    :pre-requisites="preRequisites"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="transactions.headers"
                :meta="transactions.meta"
                module="finance.transaction"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="transaction in transactions.data"
                    :key="transaction.uuid"
                >
                    <DataCell name="codeNumber">
                        {{ transaction.codeNumber }}
                        <TextMuted block v-if="transaction.referenceNumber">{{
                            transaction.referenceNumber
                        }}</TextMuted>
                        <BaseBadge
                            design="danger"
                            size="sm"
                            v-if="transaction.isCancelled"
                            >{{ $trans("general.cancelled") }}</BaseBadge
                        ><BaseBadge
                            design="danger"
                            size="sm"
                            v-if="
                                transaction.isOnline && !transaction.isCompleted
                            "
                            >{{ $trans("general.failed") }}</BaseBadge
                        >
                    </DataCell>
                    <DataCell name="primaryLedger">
                        {{ transaction.payment?.ledger?.name || "-" }}
                        <TextMuted block v-if="transaction.payment">{{
                            transaction.payment?.methodName
                        }}</TextMuted>
                        <TextMuted block v-if="transaction.head">
                            {{ transaction.head }}
                        </TextMuted>
                    </DataCell>
                    <DataCell name="type">
                        {{ transaction.type.label }}
                    </DataCell>
                    <DataCell name="date">
                        {{ transaction.date.formatted }}
                    </DataCell>
                    <DataCell name="amount">
                        {{ transaction.amount.formatted }}
                    </DataCell>
                    <DataCell name="secondaryLedger">
                        <span v-if="transaction.record">{{
                            transaction.record?.ledger?.name
                        }}</span>
                        <span v-if="transaction.transactionable?.name">
                            {{ transaction.transactionable.name }}
                            <TextMuted block>{{
                                transaction.transactionable.contact
                            }}</TextMuted>
                        </span>
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ transaction.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'FinanceTransactionShow',
                                        params: { uuid: transaction.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('transaction:edit') &&
                                    transaction.isEditable
                                "
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'FinanceTransactionEdit',
                                        params: { uuid: transaction.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('transaction:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'FinanceTransactionDuplicate',
                                        params: { uuid: transaction.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    transaction.isCancellable &&
                                    perform('transaction:cancel')
                                "
                                icon="fas fa-times"
                                @click="cancel(transaction)"
                                >{{
                                    $trans("general.cancel")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('transaction:delete') &&
                                    transaction.isEditable
                                "
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: transaction.uuid,
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
                        v-if="perform('transaction:create')"
                        @click="
                            router.push({ name: 'FinanceTransactionCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "finance.transaction.transaction"
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
    name: "FinanceTransactionList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["filter"]
if (perform("transaction:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("transaction:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "finance/transaction/"
const preRequisites = reactive({
    types: [],
    paymentMethods: [],
})
const showFilter = ref(false)

const transactions = reactive({})

const setItems = (data) => {
    Object.assign(transactions, data)
}

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const cancel = (transaction) => {
    emitter.emit("actionItem", {
        uuid: transaction.uuid,
        action: "cancel",
        confirmation: true,
    })
}
</script>
