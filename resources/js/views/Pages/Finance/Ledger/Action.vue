<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('finance.finance'), path: 'Finance' },
            {
                label: $trans('finance.ledger.ledger'),
                path: 'FinanceLedgerList',
            },
        ]"
    >
        <PageHeaderAction
            name="FinanceLedger"
            :title="$trans('finance.ledger.ledger')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <LedgerForm></LedgerForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "FinanceLedgerAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import LedgerForm from "./Form.vue"

const route = useRoute()
</script>
