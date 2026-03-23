<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('employee.employee'), path: 'Employee' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :pre-requisites="{ data: ['datePlaceholders'] }"
            @setPreRequisites="setPreRequisites"
            :init-url="initUrl"
            data-fetch="employee"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Employee"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.enableMiddleNameField"
                        name="enableMiddleNameField"
                        :label="
                            $trans(
                                'employee.config.props.enable_middle_name_field'
                            )
                        "
                        v-model:error="formErrors.enableMiddleNameField"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.enableThirdNameField"
                        name="enableThirdNameField"
                        :label="
                            $trans(
                                'employee.config.props.enable_third_name_field'
                            )
                        "
                        v-model:error="formErrors.enableThirdNameField"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1"></div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeNumberPrefix"
                        name="codeNumberPrefix"
                        :label="$trans('employee.config.props.number_prefix')"
                        v-model:error="formErrors.codeNumberPrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="number"
                        v-model="form.codeNumberDigit"
                        name="codeNumberDigit"
                        :label="$trans('employee.config.props.number_digit')"
                        v-model:error="formErrors.codeNumberDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeNumberSuffix"
                        name="codeNumberSuffix"
                        :label="$trans('employee.config.props.number_suffix')"
                        v-model:error="formErrors.codeNumberSuffix"
                    />
                </div>
                <div class="col-span-3">
                    <BaseAlert design="info">{{
                        datePlaceholderInfo
                    }}</BaseAlert>
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.uniqueIdNumber1Label"
                        name="uniqueIdNumber1Label"
                        :label="
                            $trans(
                                'employee.config.props.unique_id_number1_label'
                            )
                        "
                        v-model:error="formErrors.uniqueIdNumber1Label"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.isUniqueIdNumber1Required"
                        name="uniqueIdNumber1Required"
                        :label="
                            $trans(
                                'employee.config.props.unique_id_number1_required'
                            )
                        "
                        v-model:error="formErrors.isUniqueIdNumber1Required"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1"></div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.uniqueIdNumber2Label"
                        name="uniqueIdNumber2Label"
                        :label="
                            $trans(
                                'employee.config.props.unique_id_number2_label'
                            )
                        "
                        v-model:error="formErrors.uniqueIdNumber2Label"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.isUniqueIdNumber2Required"
                        name="uniqueIdNumber2Required"
                        :label="
                            $trans(
                                'employee.config.props.unique_id_number2_required'
                            )
                        "
                        v-model:error="formErrors.isUniqueIdNumber2Required"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1"></div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.uniqueIdNumber3Label"
                        name="uniqueIdNumber3Label"
                        :label="
                            $trans(
                                'employee.config.props.unique_id_number3_label'
                            )
                        "
                        v-model:error="formErrors.uniqueIdNumber3Label"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.isUniqueIdNumber3Required"
                        name="uniqueIdNumber3Required"
                        :label="
                            $trans(
                                'employee.config.props.unique_id_number3_required'
                            )
                        "
                        v-model:error="formErrors.isUniqueIdNumber3Required"
                    />
                </div>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeConfigGeneral",
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
    enableMiddleNameField: false,
    enableThirdNameField: false,
    codeNumberPrefix: "",
    codeNumberDigit: "",
    codeNumberSuffix: "",
    uniqueIdNumber1Label: "",
    uniqueIdNumber2Label: "",
    uniqueIdNumber3Label: "",
    isUniqueIdNumber1Required: false,
    isUniqueIdNumber2Required: false,
    isUniqueIdNumber3Required: false,
    type: "employee",
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
