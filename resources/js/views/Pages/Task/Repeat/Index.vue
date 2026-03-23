<template>
    <BaseCard v-if="task.uuid">
        <BaseAlert v-if="!task.shouldRepeat" design="info" size="xs">{{
            $trans("task.repeat.doesnt_repeat")
        }}</BaseAlert>

        <BaseAlert
            v-if="task.shouldRepeat && task.repeatation.nextRepeatDate"
            design="info"
            size="xs"
            >{{
                $trans("task.repeat.repeat_on_date", {
                    attribute: task.repeatation.nextRepeatDate.formatted,
                })
            }}</BaseAlert
        >
        <BaseAlert
            v-if="task.shouldRepeat && !task.repeatation.nextRepeatDate"
            design="error"
            size="xs"
            >{{ $trans("task.repeat.repeat_over") }}</BaseAlert
        >

        <dl
            class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2"
            v-if="task.shouldRepeat && !task.permission?.isActionable"
        >
            <BaseDataView
                :label="task.repeatation.frequencyDisplay"
                class="col-span-1 sm:col-span-2"
            >
                <template v-if="task.repeatation.frequency == 'day_wise'">
                    {{ task.repeatation.daysDisplay }}
                </template>
                <template v-else-if="task.repeatation.frequency == 'date_wise'">
                    {{ task.repeatation.datesDisplay }}
                </template>
                <template
                    v-else-if="task.repeatation.frequency == 'day_wise_count'"
                >
                    {{ task.repeatation.dayWiseCount }}
                    {{ $trans("list.durations.days") }}
                </template>
            </BaseDataView>

            <BaseDataView :label="$trans('task.repeat.props.start_date')">
                {{ task.repeatation.startDate.formatted }}
            </BaseDataView>

            <BaseDataView :label="$trans('task.repeat.props.end_date')">
                {{ task.repeatation.endDate.formatted }}
            </BaseDataView>
        </dl>

        <FormAction
            v-if="task.permission?.isActionable"
            no-card
            no-data-fetch
            cancel-action
            :pre-requisites="{ uuid: task.uuid }"
            @setPreRequisites="setPreRequisites"
            :keep-adding="false"
            action="updateRepeatation"
            :uuid="task.uuid"
            :init-url="initUrl"
            :init-form="initForm"
            :form="form"
            :after-submit="afterSubmit"
        >
            <div class="mt-4 grid grid-cols-3 gap-4">
                <div class="col-span-3">
                    <BaseSwitch
                        reverse
                        v-model="form.shouldRepeat"
                        name="shouldRepeat"
                        :label="$trans('task.repeat.props.should_repeat')"
                        v-model:error="formErrors.shouldRepeat"
                    />
                </div>
            </div>
            <template v-if="form.shouldRepeat">
                <div class="mt-4 grid grid-cols-3 gap-4">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseSelect
                            v-model="form.frequency"
                            name="frequency"
                            :label="$trans('task.repeat.props.frequency')"
                            :options="preRequisites.frequencies"
                            v-model:error="formErrors.frequency"
                        />
                    </div>
                    <div class="col-span-3 flex items-end sm:col-span-2">
                        <template v-if="form.frequency == 'day_wise'">
                            <div class="flex flex-wrap space-x-2">
                                <span
                                    v-for="day in preRequisites.days"
                                    class="border-info m-1 flex cursor-pointer items-center justify-center rounded-full border-2 px-2 py-1 text-sm"
                                    :class="{
                                        'bg-info text-white dark:text-gray-50':
                                            isSelectedDay(day.value),
                                        'text-gray-800 dark:text-gray-400':
                                            !isSelectedDay(day.value),
                                    }"
                                    @click="toggleDay(day.value)"
                                >
                                    {{ day.label }}
                                </span>
                            </div>
                        </template>

                        <template v-if="form.frequency == 'date_wise'">
                            <div class="flex flex-wrap">
                                <span
                                    v-for="date in preRequisites.dates"
                                    class="border-info m-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border-2 text-sm"
                                    :class="{
                                        'bg-info text-white dark:text-gray-50':
                                            isSelectedDate(date),
                                        'text-gray-800 dark:text-gray-400':
                                            !isSelectedDate(date),
                                    }"
                                    @click="toggleDate(date)"
                                >
                                    {{ date }}
                                </span>
                            </div>
                        </template>

                        <template v-if="form.frequency == 'day_wise_count'">
                            <BaseInput
                                type="number"
                                v-model="form.dayWiseCount"
                                name="dayWiseCount"
                                :leading-text="$trans('task.repeat.props.day')"
                                :label="$trans('task.repeat.props.day')"
                                v-model:error="formErrors.dayWiseCount"
                                autofocus
                            />
                        </template>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-4">
                    <div class="col-span-3 sm:col-span-1">
                        <DatePicker
                            v-model="form.startDate"
                            name="startDate"
                            :label="$trans('task.repeat.props.start_date')"
                            no-clear
                            v-model:error="formErrors.startDate"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <DatePicker
                            v-model="form.endDate"
                            name="endDate"
                            :label="$trans('task.repeat.props.end_date')"
                            no-clear
                            v-model:error="formErrors.endDate"
                        />
                    </div>
                </div>
            </template>
        </FormAction>
    </BaseCard>
</template>

<script>
export default {
    name: "TaskRepeatList",
}
</script>

<script setup>
import { reactive, ref, inject, watch, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()
const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

const emit = defineEmits(["refresh"])

const props = defineProps({
    task: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initForm = {
    shouldRepeat: false,
    frequency: null,
    days: [],
    dates: [],
    dayWiseCount: 1,
    startDate: "",
    endDate: "",
}

const initUrl = "task/repeat/"
const preRequisites = reactive({
    frequencies: [],
    days: [],
    dates: [],
})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const toggleDay = (day) => {
    if (form.days.includes(day)) {
        form.days.splice(form.days.indexOf(day), 1)
    } else {
        form.days.push(day)
    }
}

const isSelectedDay = (day) => {
    return form.days.includes(day)
}

const toggleDate = (date) => {
    if (form.dates.includes(date)) {
        form.dates.splice(form.dates.indexOf(date), 1)
    } else {
        form.dates.push(date)
    }
}

const isSelectedDate = (date) => {
    return form.dates.includes(date)
}

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = () => {
    Object.assign(initForm, {
        shouldRepeat: props.task.shouldRepeat,
        startDate: props.task.repeatation?.startDate?.value || "",
        endDate: props.task.repeatation?.endDate?.value || "",
        frequency: props.task.repeatation?.frequency?.value || "",
        days: props.task.repeatation?.days || [],
        dates: props.task.repeatation?.dates || [],
        dayWiseCount: props.task.repeatation?.dayWiseCount || 1,
    })

    Object.assign(form, cloneDeep(initForm))
}

const afterSubmit = () => {
    emit("refresh")
}

const completed = () => {
    emitter.emit("listItems")
}

watch(
    () => props.task.repeatation,
    (value) => {
        setForm()
    },
    { deep: true }
)

onMounted(async () => {
    setForm()
})
</script>
