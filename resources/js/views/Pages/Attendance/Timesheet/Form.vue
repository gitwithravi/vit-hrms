<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="AttendanceTimesheet"
    >
        <div class="grid grid-cols-4 gap-6">
            <div class="col-span-4 sm:col-span-1">
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
            <div class="col-span-4 sm:col-span-1">
                <DatePicker
                    v-model="form.date"
                    name="date"
                    :label="$trans('attendance.timesheet.props.date')"
                    no-clear
                    v-model:error="formErrors.date"
                />
            </div>
            <div class="col-span-4 sm:col-span-1">
                <DatePicker
                    v-model="form.inAt"
                    name="inAt"
                    :label="$trans('attendance.timesheet.props.in_at')"
                    as="time"
                    v-model:error="formErrors.inAt"
                />
            </div>
            <div class="col-span-4 sm:col-span-1">
                <DatePicker
                    v-model="form.outAt"
                    name="outAt"
                    :label="$trans('attendance.timesheet.props.out_at')"
                    as="time"
                    v-model:error="formErrors.outAt"
                />
            </div>
            <div class="col-span-4">
                <BaseTextarea
                    v-model="form.remarks"
                    name="remarks"
                    :label="$trans('attendance.timesheet.props.remarks')"
                    v-model:error="formErrors.remarks"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "AttendanceTimesheetForm",
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
    date: "",
    inAt: "",
    outAt: "",
    remarks: "",
}

const initUrl = "attendance/timesheet/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    employee: "",
    isLoaded: route.params.uuid ? false : true,
})

const setForm = (data) => {
    Object.assign(initForm, {
        employee: data.employee?.uuid,
        date: data.date.value,
        inAt: data.inAtTime.at,
        outAt: data.outAtTime.at,
        remarks: data.remarks,
    })

    Object.assign(form, cloneDeep(initForm))

    fetchData.employee = data.employee?.uuid
    fetchData.isLoaded = true
}
</script>
