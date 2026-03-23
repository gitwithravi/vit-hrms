<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('payroll.payroll'), path: 'Payroll' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :pre-requisites="{ data: ['datePlaceholders'] }"
            @setPreRequisites="setPreRequisites"
            :init-url="initUrl"
            data-fetch="payroll"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Payroll"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeNumberPrefix"
                        name="codeNumberPrefix"
                        :label="$trans('payroll.config.props.number_prefix')"
                        v-model:error="formErrors.codeNumberPrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="number"
                        v-model="form.codeNumberDigit"
                        name="codeNumberDigit"
                        :label="$trans('payroll.config.props.number_digit')"
                        v-model:error="formErrors.codeNumberDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeNumberSuffix"
                        name="codeNumberSuffix"
                        :label="$trans('payroll.config.props.number_suffix')"
                        v-model:error="formErrors.codeNumberSuffix"
                    />
                </div>
                <div class="col-span-3">
                    <BaseAlert design="info">{{
                        datePlaceholderInfo
                    }}</BaseAlert>
                </div>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollConfigGeneral",
}
</script>

<script setup>
import { inject, reactive, computed } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const $trans = inject("$trans")

const initUrl = "config/"
const formErrors = getFormErrors(initUrl)
const datePlaceholderInfo = computed(() =>
    $trans("global.placeholder_info", {
        attribute: preRequisites.datePlaceholders,
    })
)

const preRequisites = reactive({
    datePlaceholders: "",
})

const initForm = {
    codeNumberPrefix: "",
    codeNumberDigit: "",
    codeNumberSuffix: "",
    type: "payroll",
}

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, {
        datePlaceholders: data.datePlaceholders
            .map((item) => item.value)
            .join(", "),
    })
}
</script>
