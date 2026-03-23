<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('finance.ledger.ledger')"
                :navs="[{ label: $trans('finance.finance'), path: 'Finance' }]"
            >
                <PageHeaderAction
                    url="finance/ledgers/"
                    name="FinanceLedger"
                    :title="$trans('finance.ledger.ledger')"
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
                :header="ledgers.headers"
                :meta="ledgers.meta"
                module="finance.ledger"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="ledger in ledgers.data" :key="ledger.uuid">
                    <DataCell name="name">
                        {{ ledger.name }}
                        <TextMuted block>{{ ledger.alias }}</TextMuted>
                    </DataCell>
                    <DataCell name="type">
                        {{ ledger.type.name }}
                    </DataCell>
                    <DataCell name="netBalance">
                        <LedgerBalance highlight :ledger="ledger" />
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ ledger.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'FinanceLedgerShow',
                                        params: { uuid: ledger.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('ledger:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'FinanceLedgerEdit',
                                        params: { uuid: ledger.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('ledger:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'FinanceLedgerDuplicate',
                                        params: { uuid: ledger.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('ledger:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: ledger.uuid,
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
                        v-if="perform('ledger:create')"
                        @click="router.push({ name: 'FinanceLedgerCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("finance.ledger.ledger"),
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
    name: "FinanceLedgerList",
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
if (perform("ledger:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("ledger:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "finance/ledger/"
const showFilter = ref(false)

const ledgers = reactive({})

const setItems = (data) => {
    Object.assign(ledgers, data)
}
</script>
