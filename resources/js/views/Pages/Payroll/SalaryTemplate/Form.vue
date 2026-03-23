<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="PayrollSalaryTemplate"
    >
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('payroll.salary_template.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('payroll.salary_template.props.alias')"
                    v-model:error="formErrors.alias"
                    autofocus
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('payroll.salary_template.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>

        <draggable :list="form.records" item-key="uuid">
            <template #item="{ element, index }">
                <div class="mt-4 grid grid-cols-4 gap-3">
                    <div class="col-span-4 flex items-end sm:col-span-1">
                        <i class="fas fa-arrows mr-2 cursor-pointer"></i>
                        <BaseLabel
                            :class="{
                                'text-success':
                                    element.payHead.category.value == 'earning',
                                'text-danger':
                                    element.payHead.category.value ==
                                    'deduction',
                            }"
                        >
                            {{ element.payHead.name }} ({{
                                element.payHead.code
                            }})
                        </BaseLabel>
                    </div>
                    <div class="col-span-4 sm:col-span-1">
                        <BaseSelect
                            v-model="element.type"
                            :name="`records.${index}.type`"
                            :label="
                                $trans('payroll.salary_template.props.type')
                            "
                            :options="preRequisites.payHeadTypes"
                            v-model:error="formErrors[`records.${index}.type`]"
                        />
                    </div>
                    <div class="col-span-4 sm:col-span-1">
                        <template v-if="element.type == 'computation'">
                            <BaseInput
                                type="text"
                                v-model="element.computation"
                                :name="`records.${index}.computation`"
                                :label="
                                    $trans(
                                        'payroll.salary_template.props.computation'
                                    )
                                "
                                v-model:error="
                                    formErrors[`records.${index}.computation`]
                                "
                            />
                        </template>
                        <template v-if="element.type == 'production_based'">
                            <BaseSelect
                                v-model="element.attendanceType"
                                :name="`records.${index}.attendanceType`"
                                :label="$trans('attendance.type.type')"
                                :options="preRequisites.attendanceTypes"
                                label-prop="name"
                                value-prop="uuid"
                                :object-prop="true"
                                v-model:error="
                                    formErrors[
                                        `records.${index}.attendanceType`
                                    ]
                                "
                            />
                        </template>
                    </div>
                </div>
            </template>
        </draggable>
    </FormAction>
</template>

<script>
export default {
    name: "PayrollSalaryTemplateForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import draggable from "vuedraggable"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
    alias: "",
    records: [],
    description: "",
}

const initUrl = "payroll/salaryTemplate/"
const preRequisites = reactive({
    attendanceTypes: [],
    payHeadTypes: [],
    payHeads: [],
})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    preRequisites.payHeads.forEach((payHead, index) => {
        initForm.records.push({
            uuid: payHead.uuid,
            payHead,
            attendanceType: "",
            type: "",
            position: index,
            computation: "",
        })
    })

    Object.assign(form, cloneDeep(initForm))
}

const setForm = (data) => {
    let records = []
    data.records.forEach((record) => {
        records.push({
            uuid: record.uuid,
            payHead: record.payHead,
            attendanceType: record.attendanceType,
            type: record.type.value,
            position: record.position,
            computation: record.computation,
        })
    })

    Object.assign(initForm, {
        ...data,
        records,
    })
    Object.assign(form, cloneDeep(initForm))
}
</script>
