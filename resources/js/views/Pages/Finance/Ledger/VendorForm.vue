<template>
    <FormAction
        :no-card="isModal ? true : false"
        :pre-requisites="false"
        @setPreRequisites="setPreRequisites"
        :is-modal="isModal"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('finance.ledger.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.contactNumber"
                    name="contactNumber"
                    :label="$trans('finance.ledger.props.contact_number')"
                    v-model:error="formErrors.contactNumber"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "FinanceLedgerVendorForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const props = defineProps({
    isModal: {
        type: Boolean,
        default: false,
    },
})

const initForm = {
    name: "",
    type: "sundry_creditor",
    openingBalance: 0,
    contactNumber: "",
}

const initUrl = "finance/ledger/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    ledgerTypes: [],
})

const state = reactive({
    selectedLedgerType: {},
})
const form = reactive({ ...initForm })
const fetchData = reactive({
    type: "",
    isLoaded: route.params.uuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    Object.assign(form, cloneDeep(initForm))
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        openingBalance: data.openingBalance.value,
        type: data.type?.uuid || "",
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.type = data.type?.uuid || ""
    state.selectedLedgerType = data.type
    fetchData.isLoaded = true
}

const ledgerTypeSelected = (data) => {
    form.type = data.uuid || ""
}
</script>
