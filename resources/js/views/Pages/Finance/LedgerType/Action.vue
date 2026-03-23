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
                label: $trans('finance.ledger_type.ledger_type'),
                path: 'FinanceLedgerTypeList',
            },
        ]"
    >
        <PageHeaderAction
            name="FinanceLedgerType"
            :title="$trans('finance.ledger_type.ledger_type')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <LedgerTypeForm></LedgerTypeForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "FinanceLedgerTypeAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import LedgerTypeForm from "./Form.vue"

const route = useRoute()
</script>
