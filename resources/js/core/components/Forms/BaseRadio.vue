<template>
    <div class="flex items-center">
        <input
            :id="state.uniqueId"
            v-bind="$attrs"
            :checked="modelValue === value"
            @change="updateInput"
            :value="value"
            type="radio"
            class="text-primary dark:text-dark-body h-4 w-4 border-gray-300 focus:ring-0 dark:border-gray-700"
        />
        <label
            :for="state.uniqueId"
            class="ml-2 block text-sm text-gray-900 dark:text-gray-400"
        >
            <div class="flex justify-between">
                {{ label }}
                <span v-if="labelHint" class="ml-2" v-tooltip="labelHint"
                    ><i class="fas fa-question-circle"></i
                ></span>
            </div>
        </label>
    </div>
</template>

<script>
export default {
    name: "BaseRadio",
    inheritAttrs: false,
}
</script>

<script setup>
import { onMounted, reactive } from "vue"

const emit = defineEmits(["update:modelValue"])

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
        type: [String, Number, Boolean],
        default: "",
    },
    value: {
        type: [String, Number, Boolean],
        required: true,
    },
})

const state = reactive({
    uniqueId: "",
})

const updateInput = ($event) => {
    emit("update:modelValue", $event.target.value)
}

onMounted(() => {
    state.uniqueId = props.id || Math.random().toString(16).slice(2)
})
</script>
