<template>
    <div v-for="payment in payments">
        <div class="flex space-x-2">
            <span class="font-bold" v-if="showLedger && payment.ledger">{{
                payment.ledger?.name
            }}</span>
            <span class="font-semibold">{{ payment.methodName }}</span>
            <span>{{ payment.amount.formatted }}</span>
        </div>
        <TextMuted block>
            <div v-if="payment.hasInstrumentNumber && payment.instrumentNumber">
                {{
                    $trans("finance.transaction.props.instrument_number") +
                    ": " +
                    payment.instrumentNumber
                }}
            </div>
            <div
                v-if="payment.hasInstrumentDate && payment.instrumentDate.value"
            >
                {{
                    $trans("finance.transaction.props.instrument_date") +
                    ": " +
                    payment.instrumentDate.formatted
                }}
            </div>
            <div v-if="payment.hasClearingDate && payment.clearingDate.value">
                {{
                    $trans("finance.transaction.props.clearing_date") +
                    ": " +
                    payment.clearingDate.formatted
                }}
            </div>
            <div v-if="payment.hasBankDetail && payment.bankDetail">
                {{
                    $trans("finance.transaction.props.bank_detail") +
                    ": " +
                    payment.bankDetail
                }}
            </div>
            <div v-if="payment.hasReferenceNumber && payment.referenceNumber">
                {{
                    $trans("finance.transaction.props.reference_number") +
                    ": " +
                    payment.referenceNumber
                }}
            </div>
        </TextMuted>
    </div>
</template>

<script>
export default {
    name: "PaymentMethodDetail",
}
</script>

<script setup>
const props = defineProps({
    payments: {
        type: Array,
        required: true,
    },
    showLedger: {
        type: Boolean,
        default: true,
    },
})
</script>
