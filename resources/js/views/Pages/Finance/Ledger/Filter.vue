<template>
    <FilterForm
        :init-form="initForm"
        :form="form"
        :multiple="['ledgerTypes']"
        @hide="emit('hide')"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('finance.ledger.props.name')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('finance.ledger.props.alias')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="ledgerTypes"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'finance.ledger_type.ledger_type'
                            ),
                        })
                    "
                    v-model="form.ledgerTypes"
                    value-prop="uuid"
                    :init-search="fetchData.ledgerTypes"
                    search-action="finance/ledgerType/list"
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

const initForm = {
    name: "",
    alias: "",
    ledgerTypes: [],
}

const form = reactive({ ...initForm })

const fetchData = reactive({
    ledgerTypes: [],
    isLoaded: route.query.ledgerTypes ? false : true,
})

onMounted(async () => {
    fetchData.ledgerTypes = route.query.ledgerTypes
        ? route.query.ledgerTypes.split(",")
        : []
    fetchData.isLoaded = true
})
</script>
