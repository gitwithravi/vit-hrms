<template>
    <BaseLabel :for="state.uniqueId" v-if="label">
        {{ label }}
        <span v-if="labelHint" class="ml-2" v-tooltip="labelHint"
            ><i class="fas fa-question-circle"></i
        ></span>
    </BaseLabel>
    <div
        class="relative"
        :class="{
            'mt-1': label,
        }"
    >
        <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
        >
            <i
                v-if="as !== 'time'"
                class="fas fa-calendar text-gray-400"
                aria-hidden="true"
            ></i>
            <i v-else class="fas fa-clock text-gray-400" aria-hidden="true"></i>
        </div>
        <flat-pickr
            :id="state.uniqueId"
            v-bind="$attrs"
            :placeholder="placeholder || label"
            class="focus:border-primary block w-full border-0 border-gray-300 bg-transparent pl-10 text-sm focus:ring-0 dark:border-gray-700 dark:text-gray-200 dark:focus:border-gray-200"
            :class="{
                'pr-10': !noClear,
                'border-b-2 shadow-sm': !slim,
                'py-0 text-xs': slim,
            }"
            :config="getConfig"
            v-model="state.input"
            @onValueUpdate="onValueUpdate"
            :events="[
                'onValueUpdate',
                'onChange',
                'onClose',
                'onOpen',
                'onMonthChange',
                'onYearChange',
            ]"
        />
        <div
            v-if="!noClear && state.input"
            class="absolute inset-y-0 right-0 flex cursor-pointer items-center pr-3"
            @click="clearInput"
        >
            <i class="fas fa-times text-gray-400" aria-hidden="true"></i>
        </div>
    </div>
    <FormError :error="error" />
</template>

<script>
export default {
    name: "DatePicker",
    inheritAttrs: false,
}
</script>

<script setup>
import { onMounted, reactive, computed, watch } from "vue"
import monthSelectPlugin from "@plugins/js/monthSelect"

const emit = defineEmits([
    "update:modelValue",
    "update:start",
    "update:end",
    "update:error",
    "change",
])

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    labelHint: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    modelValue: {
        type: String,
        default: "",
    },
    error: {
        type: String,
        default: "",
    },
    start: {
        type: String,
        default: "",
    },
    end: {
        type: String,
        default: "",
    },
    config: {
        type: Object,
        default: {},
    },
    as: {
        type: String,
        validator(value) {
            return [
                "date",
                "multiple",
                "datetime",
                "time",
                "range",
                "month",
                "dayMonth",
            ].includes(value)
        },
        default: "date",
    },
    noClear: {
        type: Boolean,
        default: false,
    },
    slim: {
        type: Boolean,
        default: false,
    },
})

const getConfig = computed(() => {
    if (props.as === "date") {
        return Object.assign(datePickerConfig, props.config)
    } else if (props.as === "multiple") {
        return Object.assign(multiDatePickerConfig, props.config)
    } else if (props.as === "datetime") {
        return Object.assign(dateTimePickerConfig, props.config)
    } else if (props.as === "time") {
        return Object.assign(timePickerConfig, props.config)
    } else if (props.as === "range") {
        return Object.assign(rangePickerConfig, props.config)
    } else if (props.as === "month") {
        return Object.assign(monthPickerConfig, props.config)
    } else if (props.as === "dayMonth") {
        return Object.assign(dayMonthPickerConfig, props.config)
    }
    return props.config
})

const state = reactive({
    uniqueId: "",
    input: props.modelValue,
})

const updateInput = ($event) => {
    emit("update:error", "")

    if (props.as === "range") {
        const dates = $event.target.value.split(" - ")
        if (dates.length > 1) {
            emit("update:start", dates[0])
            emit("update:end", dates[1])
        } else {
            emit("update:start", dates[0])
            emit("update:end", dates[0])
        }
    } else {
        emit("update:modelValue", $event.target.value)
    }
}

const onValueUpdate = (value, dateStr) => {
    emit("update:error", "")

    if (props.as === "range") {
        const dates = dateStr.split(" - ")
        if (dates.length > 1) {
            emit("update:start", dates[0])
            emit("update:end", dates[1])
        } else {
            emit("update:start", dates[0])
            emit("update:end", dates[0])
        }
    } else {
        emit("update:modelValue", dateStr)
    }
    emit("change", dateStr)
}

const onChange = (dates, dateStr) => {
    emit("change", dateStr)
}

const clearInput = () => {
    state.input = ""
    if (props.as != "range") {
        emit("update:modelValue", "")
    }
    emit("update:error", "")

    if (props.as === "range") {
        emit("update:start", "")
        emit("update:end", "")
    }
}

watch(
    () => [props.modelValue, props.start, props.end],
    (value) => {
        let date = value[0]
        let start = value[1]
        let end = value[2]

        if (props.as === "range" && !start && !end) {
            state.input = ""
        } else if (props.as === "range" && !state.input) {
            state.input = start + " - " + end
        }

        if (props.as != "range") {
            state.input = date
        }
    }
)

onMounted(() => {
    state.uniqueId = props.id || Math.random().toString(16).slice(2)
})

const datePickerConfig = {
    wrap: true,
    allowInput: false,
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "M j Y",
    locale: {
        firstDayOfWeek: 1,
    },
    disableMobile: "true",
}

const multiDatePickerConfig = {
    wrap: true,
    mode: "multiple",
    allowInput: false,
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "M j Y",
    locale: {
        firstDayOfWeek: 1,
    },
    disableMobile: "true",
}

const monthPickerConfig = {
    plugins: [
        new monthSelectPlugin({
            shorthand: true,
            dateFormat: "Y-m",
        }),
    ],
    disableMobile: "true",
}

const dayMonthPickerConfig = {
    wrap: true,
    allowInput: false,
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "M j",
    locale: {
        firstDayOfWeek: 1,
    },
    disableMobile: "true",
}

const rangePickerConfig = {
    wrap: true,
    mode: "range",
    allowInput: false,
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "M j Y",
    locale: {
        firstDayOfWeek: 1,
        rangeSeparator: " - ",
    },
    disableMobile: "true",
}

const timePickerConfig = {
    enableTime: true,
    noCalendar: true,
    altFormat: "h:i K",
    dateFormat: "H:i:S",
    time_24hr: false,
    wrap: true,
    allowInput: false,
    altInput: true,
    disableMobile: "true",
}

const dateTimePickerConfig = {
    enableTime: true,
    wrap: true,
    allowInput: false,
    altFormat: "M j Y h:i K",
    dateFormat: "Y-m-d H:i:S",
    time_24hr: false,
    altInput: true,
    locale: {
        firstDayOfWeek: 1,
    },
    disableMobile: "true",
}
</script>
