<template>
    <template v-if="selectedPaymentMethod.uuid">
        <div
            class="col-span-4 sm:col-span-1"
            v-if="selectedPaymentMethod.hasInstrumentNumber"
        >
            <BaseInput
                type="text"
                v-model="form.instrumentNumber"
                name="instrumentNumber"
                :label="$trans('finance.transaction.props.instrument_number')"
                v-model:error="formErrors.instrumentNumber"
                @input="$emit('update:instrumentNumber', $event.target.value)"
            />
        </div>
        <div
            class="col-span-4 sm:col-span-1"
            v-if="selectedPaymentMethod.hasInstrumentDate"
        >
            <DatePicker
                v-model="form.instrumentDate"
                name="instrumentDate"
                :label="$trans('finance.transaction.props.instrument_date')"
                v-model:error="formErrors.instrumentDate"
                @input="$emit('update:instrumentDate', $event.target.value)"
            />
        </div>
        <div
            class="col-span-4 sm:col-span-1"
            v-if="selectedPaymentMethod.hasClearingDate"
        >
            <DatePicker
                v-model="form.clearingDate"
                name="clearingDate"
                :label="$trans('finance.transaction.props.clearing_date')"
                v-model:error="formErrors.clearingDate"
                @input="$emit('update:clearingDate', $event.target.value)"
            />
        </div>
        <div
            class="col-span-4 sm:col-span-1"
            v-if="selectedPaymentMethod.hasBankDetail"
        >
            <BaseInput
                type="text"
                v-model="form.bankDetail"
                name="bankDetail"
                :label="$trans('finance.transaction.props.bank_detail')"
                v-model:error="formErrors.bankDetail"
                @input="$emit('update:bankDetail', $event.target.value)"
            />
        </div>
        <div
            class="col-span-4 sm:col-span-1"
            v-if="selectedPaymentMethod.hasReferenceNumber"
        >
            <BaseInput
                type="text"
                v-model="form.referenceNumber"
                name="referenceNumber"
                :label="$trans('finance.transaction.props.reference_number')"
                v-model:error="formErrors.referenceNumber"
                @input="$emit('update:referenceNumber', $event.target.value)"
            />
        </div>
    </template>
</template>

<script>
export default {
    name: "PaymentMethodInput",
}
</script>

<script setup>
import { computed, reactive, onMounted, watch } from "vue"
import { useStore } from "vuex"

const store = useStore()

const props = defineProps({
    selectedPaymentMethod: {
        type: Object,
        default() {
            return {}
        },
    },
    instrumentNumber: {
        type: String,
        default: "",
    },
    instrumentDate: {
        type: String,
        default: "",
    },
    clearingDate: {
        type: String,
        default: "",
    },
    bankDetail: {
        type: String,
        default: "",
    },
    referenceNumber: {
        type: String,
        default: "",
    },
    formErrors: {
        type: Object,
        default() {
            return {}
        },
    },
})

const form = reactive({
    instrumentNumber: "",
    instrumentDate: "",
    clearingDate: "",
    bankDetail: "",
    referenceNumber: "",
})

onMounted(() => {
    form.instrumentNumber = props.instrumentNumber
    form.instrumentDate = props.instrumentDate
    form.clearingDate = props.clearingDate
    form.bankDetail = props.bankDetail
    form.referenceNumber = props.referenceNumber
})

watch(
    () => [
        props.instrumentNumber,
        props.instrumentDate,
        props.clearingDate,
        props.bankDetail,
        props.referenceNumber,
    ],
    (value) => {
        form.instrumentNumber = value[0]
        form.instrumentDate = value[1]
        form.clearingDate = value[2]
        form.bankDetail = value[3]
        form.referenceNumber = value[4]
    }
)
</script>
