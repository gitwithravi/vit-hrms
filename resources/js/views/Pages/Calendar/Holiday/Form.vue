<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="CalendarHoliday"
    >
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('calendar.holiday.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-2 sm:col-span-1" v-if="!route.params.uuid">
                <BaseRadioGroup
                    :options="[
                        {
                            label: $trans('calendar.holiday.props.type_range'),
                            value: 'range',
                        },
                        {
                            label: $trans('calendar.holiday.props.type_dates'),
                            value: 'dates',
                        },
                    ]"
                    name="type"
                    v-model="form.type"
                    v-model:error="formErrors.type"
                    horizontal
                />
            </div>
            <div class="col-span-2 sm:col-span-1" v-if="form.type == 'range'">
                <DatePicker
                    v-model:start="form.startDate"
                    v-model:end="form.endDate"
                    name="dateBetween"
                    as="range"
                    :label="$trans('general.date_between')"
                />
            </div>
            <div class="col-span-2 sm:col-span-1" v-if="form.type == 'dates'">
                <DatePicker
                    v-model="form.dates"
                    name="dates"
                    as="multiple"
                    :label="$trans('calendar.holiday.props.dates')"
                    no-clear
                    v-model:error="formErrors.dates"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('calendar.holiday.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "CalendarHolidayForm",
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
    type: "range",
    startDate: "",
    endDate: "",
    dates: "",
    description: "",
}

const initUrl = "calendar/holiday/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        startDate: data.startDate.value,
        endDate: data.endDate.value,
    })
    Object.assign(form, cloneDeep(initForm))
}
</script>
