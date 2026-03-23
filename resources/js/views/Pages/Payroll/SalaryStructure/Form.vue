<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="PayrollSalaryStructure"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="employee"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('employee.employee'),
                        })
                    "
                    v-model="form.employee"
                    v-model:error="formErrors.employee"
                    value-prop="uuid"
                    :init-search="fetchData.employee"
                    :additional-search-query="{ self: 0 }"
                    search-action="employee/list"
                >
                    <template #selectedOption="slotProps">
                        {{ slotProps.value.name }} ({{
                            slotProps.value.codeNumber
                        }})
                    </template>

                    <template #listOption="slotProps">
                        {{ slotProps.option.name }} ({{
                            slotProps.option.codeNumber
                        }})
                    </template>
                </BaseSelectSearch>
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="salaryTemplate"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'payroll.salary_template.salary_template'
                            ),
                        })
                    "
                    v-model="form.salaryTemplate"
                    v-model:error="formErrors.salaryTemplate"
                    value-prop="uuid"
                    :init-search="fetchData.salaryTemplate"
                    :additional-search-query="{ record: 1 }"
                    search-action="payroll/salaryTemplate/list"
                    @selected="salaryTemplateSelected"
                    @removed="salaryTemplateRemoved"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.effectiveDate"
                    name="effectiveDate"
                    :label="
                        $trans('payroll.salary_structure.props.effective_date')
                    "
                    no-clear
                    v-model:error="formErrors.effectiveDate"
                />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-3" v-if="form.records.length > 0">
            <template
                v-for="(record, index) in form.records"
                :key="record.uuid"
            >
                <div class="col-span-3 sm:col-span-1">
                    <BaseLabel
                        :class="{
                            'text-success': record.payHead.type == 'earning',
                            'text-danger': record.payHead.type == 'deduction',
                        }"
                    >
                        {{ record.payHead.name }} {{ record.payHead.code }}
                        <span v-if="record.unit"
                            >({{ record.unit.label }})</span
                        >
                    </BaseLabel>
                    <BaseInput
                        currency
                        type="text"
                        v-model="record.amount"
                        :name="`records.${index}.amount`"
                        :placeholder="
                            $trans('payroll.salary_structure.props.amount')
                        "
                        v-model:error="formErrors[`records.${index}.amount`]"
                    />
                </div>
            </template>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-3">
            <div class="col-span-3">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="
                        $trans('payroll.salary_structure.props.description')
                    "
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "PayrollSalaryStructureForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    employee: "",
    salaryTemplate: "",
    effectiveDate: "",
    records: [],
    description: "",
}

const initUrl = "payroll/salaryStructure/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    employee: "",
    salaryTemplate: "",
    isLoaded: route.params.uuid ? false : true,
})

const setForm = (data) => {
    let filteredRecords = data.records.filter((record) => {
        return record.enableUserInput
    })

    let records = []
    filteredRecords.forEach((record) => {
        records.push({
            uuid: record.uuid,
            unit: record.unit,
            payHead: record.payHead,
            amount: record.amount.value,
        })
    })

    Object.assign(initForm, {
        employee: data.employee?.uuid,
        salaryTemplate: data.template?.uuid,
        effectiveDate: data.effectiveDate.value,
        records: records,
        description: data.description,
    })

    Object.assign(form, cloneDeep(initForm))

    fetchData.employee = data.employee?.uuid
    fetchData.salaryTemplate = data.template?.uuid
    fetchData.isLoaded = true
}

const salaryTemplateSelected = (selectedOption) => {
    form.records = []
    selectedOption.records.forEach((record) => {
        if (record.enableUserInput) {
            form.records.push({
                uuid: record.uuid,
                unit: record.unit,
                payHead: record.payHead,
                amount: "",
            })
        }
    })
}

const salaryTemplateRemoved = (selectedOption) => {
    form.records = []
}
</script>
