<template>
    <BaseLabel :for="state.uniqueId" v-if="label">
        {{ label }}
        <span v-if="labelHint" class="ml-2" v-tooltip="labelHint"
            ><i class="fas fa-question-circle"></i
        ></span>
    </BaseLabel>
    <div class="mt-1 lg:flex lg:space-x-2">
        <div
            v-for="option in options"
            class="border-primary mx-1 my-2 flex-1 cursor-pointer rounded-lg border-2 px-4 py-2 text-sm dark:border-gray-400"
            :class="{
                'bg-primary text-white dark:bg-gray-500 dark:text-gray-50':
                    isSelected(option.value),
                'text-gray-800 dark:text-gray-400': !isSelected(option.value),
            }"
            @click="changed(option.value)"
        >
            <div class="flex h-full items-center justify-between align-middle">
                <div>
                    <span v-if="option.icon"
                        ><i class="mr-2" :class="option.icon"></i
                    ></span>
                    {{ option.label }}
                    <div v-if="option.detail">
                        <span
                            class="text-xs"
                            :class="{
                                'text-gray-500 dark:text-gray-400': !isSelected(
                                    option.value
                                ),
                                'text-gray-300 dark:text-gray-200': isSelected(
                                    option.value
                                ),
                            }"
                            >{{ option.detail }}</span
                        >
                    </div>
                </div>
                <span v-if="isSelected(option.value)" class=""
                    ><i class="fas fa-check-circle"></i
                ></span>
            </div>
        </div>
    </div>
    <FormError :error="error" />
</template>

<script>
export default {
    name: "CustomCheckbox",
}
</script>

<script setup>
import { reactive, inject, onMounted } from "vue"

const emit = defineEmits(["update:modelValue", "update:error"])

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    labelHint: {
        type: String,
        default: "",
    },
    modelValue: {
        type: [String, Number, Array],
        default: "",
    },
    limit: {
        type: Number,
        default: -1,
    },
    error: {
        type: String,
        default: "",
    },
    options: {
        type: Array,
        default: [],
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

const $trans = inject("$trans")

const state = reactive({
    uniqueId: "",
})

const isSelected = (value) => {
    if (Array.isArray(props.modelValue)) {
        return props.modelValue.includes(value)
    }
    return props.modelValue == value
}

const changed = (value) => {
    if (props.disabled) {
        return
    }

    if (Array.isArray(props.modelValue)) {
        let finalValue = [...props.modelValue]
        if (props.modelValue.includes(value)) {
            finalValue = finalValue.filter((v) => v != value)
        } else {
            if (props.limit > 0 && finalValue.length >= props.limit) {
                emit(
                    "update:error",
                    $trans("global.max_select_limit", { max: props.limit })
                )
                return
            }
            finalValue.push(value)
        }
        emit("update:modelValue", finalValue)
    } else {
        emit("update:modelValue", value)
    }

    emit("update:error", "")
}

onMounted(() => {
    state.uniqueId = props.id || Math.random().toString(16).slice(2)
})
</script>
