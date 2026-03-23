<template>
    <div
        :class="{
            'flex space-x-4': horizontal,
            'mt-4': topMargin,
            'mt-8': doubleTopMargin,
        }"
    >
        <BaseRadio
            :disabled="disabled"
            v-for="option in getOptions"
            :key="option.value"
            :label="option.label"
            :value="option.value"
            :name="name"
            :modelValue="modelValue"
            @update:modelValue="updateInput"
        />
    </div>
    <FormError :error="error" />
</template>

<script>
export default {
    name: "BaseRadioGroup",
    inheritAttrs: false,
}
</script>

<script setup>
import { onMounted, reactive, computed, inject } from "vue"

const emit = defineEmits(["update:modelValue", "update:error", "change"])

const props = defineProps({
    options: {
        type: Array,
        required: false,
        default: [],
    },
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number, Boolean],
        required: true,
    },
    error: {
        type: String,
        default: "",
    },
    horizontal: {
        type: Boolean,
        default: false,
    },
    topMargin: {
        type: Boolean,
        default: false,
    },
    doubleTopMargin: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    predefinedOption: {
        type: String,
        default: "",
    },
})

const $trans = inject("$trans")

const predefinedOptions = {
    yes_no: [
        { label: $trans("general.yes"), value: 1 },
        { label: $trans("general.no"), value: 0 },
    ],
}

const getOptions = computed(() => {
    if (props.predefinedOption) {
        return predefinedOptions[props.predefinedOption]
    }

    return props.options
})

const updateInput = ($event) => {
    emit("update:modelValue", $event)
    emit("update:error", "")
    emit("change")
}
</script>
