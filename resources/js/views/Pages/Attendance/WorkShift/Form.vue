<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="AttendanceWorkShift"
    >
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('attendance.work_shift.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('attendance.work_shift.props.code')"
                    v-model:error="formErrors.code"
                    autofocus
                />
            </div>
            <div class="col-span-2">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('attendance.work_shift.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>

        <div
            class="mt-4 grid grid-cols-4 gap-3"
            v-for="(record, index) in form.records"
            :key="record.day"
        >
            <div class="col-span-4 flex items-end sm:col-span-1">
                <BaseLabel class="mt-4">
                    {{ record.label }}
                </BaseLabel>
            </div>
            <div class="col-span-4 flex items-end space-x-4 sm:col-span-1">
                <BaseSwitch
                    reverse
                    v-model="record.isHoliday"
                    :name="`records.${index}.isHoliday`"
                    :label="$trans('attendance.work_shift.props.is_holiday')"
                    v-model:error="formErrors[`records.${index}.isHoliday`]"
                />
                <BaseSwitch
                    v-if="!record.isHoliday"
                    reverse
                    v-model="record.isOvernight"
                    :name="`records.${index}.isOvernight`"
                    :label="$trans('attendance.work_shift.props.is_overnight')"
                    v-model:error="formErrors[`records.${index}.isOvernight`]"
                />
            </div>
            <template v-if="!record.isHoliday">
                <div class="col-span-4 sm:col-span-1">
                    <DatePicker
                        :name="`records.${index}.startTime`"
                        v-model="record.startTime"
                        :placeholder="
                            $trans('attendance.work_shift.props.start_time')
                        "
                        as="time"
                        v-model:error="formErrors[`records.${index}.startTime`]"
                    />
                </div>
                <div class="col-span-4 sm:col-span-1">
                    <DatePicker
                        :name="`records.${index}.endTime`"
                        v-model="record.endTime"
                        :placeholder="
                            $trans('attendance.work_shift.props.end_time')
                        "
                        as="time"
                        v-model:error="formErrors[`records.${index}.endTime`]"
                    />
                </div>
            </template>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "AttendanceWorkShiftForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
    code: "",
    records: [],
    description: "",
}

const initUrl = "attendance/workShift/"
const preRequisites = reactive({
    days: [],
})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
    preRequisites.days.forEach((day) => {
        initForm.records.push({
            day: day.value,
            label: day.label,
            isHoliday: false,
            isOvernight: false,
            startTime: "",
            endTime: "",
        })
    })

    Object.assign(form, cloneDeep(initForm))
}

const setForm = (data) => {
    Object.assign(initForm, {
        name: data.name,
        code: data.code,
        records: data.records,
        description: data.description,
    })

    Object.assign(form, cloneDeep(initForm))
}
</script>
