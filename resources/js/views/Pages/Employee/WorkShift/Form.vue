<template>
    <FormAction
        no-data-fetch
        :init-url="initUrl"
        :uuid="route.params.uuid"
        :module-uuid="route.params.muuid"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        :redirect="{
            name: 'EmployeeWorkShift',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="workShift"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'attendance.work_shift.work_shift'
                            ),
                        })
                    "
                    v-model="form.workShift"
                    v-model:error="formErrors.workShift"
                    :init-search="fetchData.workShift"
                    init-search-key="name"
                    search-action="attendance/workShift/list"
                >
                    <template #selectedOption="slotProps">
                        {{ slotProps.value.name }} ({{ slotProps.value.code }})
                    </template>

                    <template #listOption="slotProps">
                        {{ slotProps.option.name }} ({{
                            slotProps.option.code
                        }})
                    </template>
                </BaseSelectSearch>
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.startDate"
                    name="startDate"
                    :label="$trans('attendance.work_shift.props.start_date')"
                    v-model:error="formErrors.startDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.endDate"
                    name="endDate"
                    :label="$trans('attendance.work_shift.props.end_date')"
                    v-model:error="formErrors.endDate"
                />
            </div>
        </div>
        <div class="mt-4 grid grid-cols-1">
            <div class="col">
                <BaseTextarea
                    v-model="form.remarks"
                    name="remarks"
                    :label="$trans('attendance.work_shift.props.remarks')"
                    v-model:error="formErrors.remarks"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "EmployeeWorkShiftForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"
import { cloneDeep } from "@core/utils"

const route = useRoute()

const initForm = {
    workShift: "",
    startDate: "",
    endDate: "",
    remarks: "",
}

const initUrl = "employee/workShift/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    workShift: "",
    isLoaded: route.params.muuid ? false : true,
})

const setForm = (data) => {
    Object.assign(initForm, {
        startDate: data.startDate.value,
        endDate: data.endDate.value,
        workShift: data.workShift?.uuid,
        remarks: data.remarks,
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.workShift = data.workShift?.name
    fetchData.isLoaded = true
}
</script>
