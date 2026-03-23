<template>
    <FilterForm
        :init-form="initForm"
        :form="form"
        :multiple="['ledgers', 'types', 'paymentMethods', 'secondaryLedgers']"
        @hide="emit('hide')"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.codeNumber"
                    name="codeNumber"
                    :label="$trans('finance.transaction.props.code_number')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    multiple
                    v-model="form.types"
                    name="types"
                    :label="$trans('finance.transaction.props.type')"
                    :options="state.types"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    multiple
                    v-model="form.paymentMethods"
                    name="paymentMethods"
                    :label="$trans('finance.payment_method.payment_method')"
                    label-prop="name"
                    value-prop="uuid"
                    :options="state.paymentMethods"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="ledgers"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('finance.ledger.ledger'),
                        })
                    "
                    v-model="form.ledgers"
                    label-props="name"
                    value-prop="uuid"
                    :init-search="fetchData.ledgers"
                    search-action="finance/ledger/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="secondaryLedgers"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'finance.ledger.secondary_ledger'
                            ),
                        })
                    "
                    v-model="form.secondaryLedgers"
                    label-props="name"
                    value-prop="uuid"
                    :init-search="fetchData.secondaryLedgers"
                    search-action="finance/ledger/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model:start="form.startDate"
                    v-model:end="form.endDate"
                    name="dateBetween"
                    as="range"
                    :label="$trans('general.date_between')"
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()

const emit = defineEmits(["hide"])

const props = defineProps({
    preRequisites: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initForm = {
    codeNumber: "",
    types: [],
    paymentMethods: [],
    ledgers: [],
    secondaryLedgers: [],
    startDate: "",
    endDate: "",
}

const form = reactive({ ...initForm })

const fetchData = reactive({
    isLoaded:
        route.query.types ||
        route.query.paymentMethods ||
        route.query.ledgers ||
        route.query.secondaryLedgers
            ? false
            : true,
})

const state = reactive({
    types: props.preRequisites.types,
    paymentMethods: props.preRequisites.paymentMethods,
})

onMounted(async () => {
    fetchData.types = route.query.types ? route.query.types.split(",") : []
    fetchData.paymentMethods = route.query.paymentMethods
        ? route.query.paymentMethods.split(",")
        : []
    fetchData.ledgers = route.query.ledgers
        ? route.query.ledgers.split(",")
        : []
    fetchData.secondaryLedgers = route.query.secondaryLedgers
        ? route.query.secondaryLedgers.split(",")
        : []
    fetchData.isLoaded = true
})
</script>
