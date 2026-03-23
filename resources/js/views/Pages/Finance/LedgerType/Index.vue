<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('finance.ledger_type.ledger_type')"
                :navs="[{ label: $trans('finance.finance'), path: 'Finance' }]"
            >
                <PageHeaderAction
                    url="finance/ledger-types/"
                    name="FinanceLedgerType"
                    :title="$trans('finance.ledger_type.ledger_type')"
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
                :header="ledgerTypes.headers"
                :meta="ledgerTypes.meta"
                module="finance.ledger_type"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="ledgerType in ledgerTypes.data"
                    :key="ledgerType.uuid"
                >
                    <DataCell name="name">
                        {{ ledgerType.name }}
                    </DataCell>
                    <DataCell name="isDefault">
                        <i
                            class="far fa-check-circle fa-xl text-success"
                            v-if="ledgerType.isDefault"
                            v-tooltip="$trans('general.default')"
                        ></i>
                    </DataCell>
                    <DataCell name="alias">
                        {{ ledgerType.alias || "-" }}
                    </DataCell>
                    <DataCell name="parent">
                        {{ ledgerType.parent?.name || "-" }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ ledgerType.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'FinanceLedgerTypeShow',
                                        params: { uuid: ledgerType.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('ledger-type:edit') &&
                                    !ledgerType.isDefault
                                "
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'FinanceLedgerTypeEdit',
                                        params: { uuid: ledgerType.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('ledger-type:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'FinanceLedgerTypeDuplicate',
                                        params: { uuid: ledgerType.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('ledger-type:delete') &&
                                    !ledgerType.isDefault
                                "
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: ledgerType.uuid,
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
                        v-if="perform('ledger-type:create')"
                        @click="
                            router.push({ name: 'FinanceLedgerTypeCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "finance.ledger_type.ledger_type"
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
    name: "FinanceLedgerTypeList",
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
if (perform("ledger-type:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("ledger-type:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "finance/ledgerType/"
const showFilter = ref(false)

const ledgerTypes = reactive({})

const setItems = (data) => {
    Object.assign(ledgerTypes, data)
}
</script>
