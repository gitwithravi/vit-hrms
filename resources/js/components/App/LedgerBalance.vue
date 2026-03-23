<template>
    <span
        v-if="show && ledger?.uuid"
        class="mt-1"
        :class="{
            'text-sm': true,
            'font-semibold': highlight,
            'text-success': ledger.balanceColor == 'success',
            'text-danger': ledger.balanceColor == 'danger',
        }"
    >
        <span v-if="label">
            {{
                $trans("finance.ledger.props.balance", {
                    attribute: ledger.balance.formatted,
                })
            }}
        </span>
        <span v-else>{{ ledger.balance.formatted }}</span>
    </span>
</template>

<script>
export default {
    name: "LedgerBalance",
}
</script>

<script setup>
const props = defineProps({
    ledger: {
        type: Object,
        default() {
            return {}
        },
    },
    show: {
        type: Boolean,
        default: true,
    },
    highlight: {
        type: Boolean,
        default: false,
    },
    label: {
        type: Boolean,
        default: null,
    },
})
</script>
