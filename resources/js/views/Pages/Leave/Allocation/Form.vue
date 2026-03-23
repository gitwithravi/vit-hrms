<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="LeaveAllocation"
    >
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 sm:col-span-1">
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
                    search-key="name"
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
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model:start="form.startDate"
                    v-model:end="form.endDate"
                    name="dateBetween"
                    as="range"
                    :label="$trans('general.date_between')"
                />
            </div>
            <div class="col-span-2">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('leave.allocation.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>

        <div
            class="mt-4 grid grid-cols-4 gap-3"
            v-for="(record, index) in form.records"
            :key="record.leaveType.uuid"
        >
            <div class="col-span-4 sm:col-span-1">
                <BaseLabel class="mt-4">
                    {{ record.leaveType.name }}
                    <span v-if="record.leaveType.alias"
                        >({{ record.leaveType.alias }})</span
                    >
                </BaseLabel>
            </div>
            <div class="col-span-4 sm:col-span-1">
                <BaseInput
                    type="number"
                    :name="`records.${index}.allotted`"
                    v-model="record.allotted"
                    :placeholder="$trans('leave.allocation.props.allotted')"
                    v-model:error="formErrors[`records.${index}.allotted`]"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "LeaveAllocationForm",
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
    startDate: "",
    endDate: "",
    records: [],
    description: "",
}

const initUrl = "leave/allocation/"
const preRequisites = reactive({
    leaveTypes: [],
})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    employee: "",
    isLoaded: route.params.uuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    preRequisites.leaveTypes.forEach((leaveType) => {
        initForm.records.push({
            leaveType,
            allotted: 0,
        })
    })

    Object.assign(form, cloneDeep(initForm))
}

const setForm = (data) => {
    Object.assign(initForm, {
        employee: data.employee?.uuid,
        startDate: data.startDate.value,
        endDate: data.endDate.value,
        description: data.description,
    })

    initForm.records.forEach((record) => {
        let leaveAllocationRecord = data.records.find(
            (o) => o.leaveType.uuid == record.leaveType.uuid
        )

        if (leaveAllocationRecord !== undefined) {
            record.leaveType = leaveAllocationRecord.leaveType
            record.allotted = leaveAllocationRecord.allotted
        }
    })

    Object.assign(form, cloneDeep(initForm))

    fetchData.employee = data.employee?.uuid
    fetchData.isLoaded = true
}
</script>
