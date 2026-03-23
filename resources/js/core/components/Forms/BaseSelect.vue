<template>
    <BaseLabel :for="state.uniqueId" v-if="label">
        {{ label }}
        <span v-if="labelHint" class="ml-2" v-tooltip="labelHint"
            ><i class="fas fa-question-circle"></i
        ></span>
    </BaseLabel>
    <div
        class="relative rounded-md shadow-sm"
        :class="{
            'mt-1': label,
        }"
    >
        <Multiselect
            :mode="getMode"
            :id="state.uniqueId"
            v-bind="$attrs"
            :closeOnSelect="getMode == 'single' ? true : false"
            :create-option="getMode == 'tags' ? true : false"
            :placeholder="placeholder || label"
            v-model="state.input"
            :label="labelProp"
            :valueProp="valueProp"
            :searchable="searchable"
            :hideSelected="false"
            :options="options"
            :object="objectProp"
            @change="updateInput"
            @select="selected"
            @deselect="removed"
            :noOptionsText="
                Array.isArray(options)
                    ? $trans('general.select_no_option')
                    : $trans('general.select_no_option_text')
            "
            :noResultsText="$trans('general.select_no_result_text')"
            :classes="{
                container:
                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border-0 border-gray-300 dark:border-gray-700 dark:text-gray-200 bg-transparent text-sm leading-snug outline-none focus:ring-0 ' +
                    (invisible ? '' : ' border-b-2 ') +
                    (minWidth ? ' w-48 min-w-full' : ' w-full '),
                containerDisabled:
                    'cursor-default bg-transparent dark:bg-gray-800',
                containerOpen: 'rounded-b-none',
                containerOpenTop: 'rounded-t-none',
                containerActive: 'outline-none focus:ring-0',
                wrapper:
                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer outline-none',
                singleLabel:
                    'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5 text-sm',
                singleLabelText:
                    'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full text-sm',
                multipleLabel:
                    'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5 text-sm',
                search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-sm font-sans bg-transparent rounded pl-3.5 focus:ring-0 rtl:pl-0 rtl:pr-3.5',
                tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2 min-w-0 rtl:pl-0 rtl:pr-2',
                tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap min-w-0 rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
                tagDisabled: 'pr-2 !bg-gray-400 text-white opacity-50 rtl:pl-2',
                tagWrapper:
                    'whitespace-nowrap overflow-hidden overflow-ellipsis',
                tagWrapperBreak: 'whitespace-normal break-all',
                tagRemove:
                    'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                tagRemoveIcon:
                    'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                tagsSearchWrapper:
                    'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                tagsSearch:
                    'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-sm font-sans box-border w-full',
                tagsSearchCopy:
                    'invisible whitespace-pre-wrap inline-block h-px',
                placeholder:
                    'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none rtl:mr-0 rtl:ml-3.5',
                caretOpen: 'rotate-180 pointer-events-auto',
                clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 rtl:pr-0 rtl:pl-3.5',
                clearIcon:
                    'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                spinner:
                    'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0 rtl:mr-0 rtl:ml-3.5',
                infinite: 'flex items-center justify-center w-full',
                infiniteSpinner:
                    'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5',
                dropdown:
                    'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 dark:border-gray-700 -mt-px overflow-y-scroll z-50 bg-white dark:bg-dark-header flex flex-col rounded-b',
                dropdownTop:
                    '-translate-y-full top-px bottom-auto rounded-b-none rounded-t',
                dropdownHidden: 'hidden',
                options: 'flex flex-col p-0 m-0 list-none dark:text-gray-400',
                optionsTop: '',
                group: 'p-0 m-0',
                groupLabel:
                    'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 dark:bg-gray-700 cursor-default leading-normal',
                groupLabelPointable: 'cursor-pointer',
                groupLabelPointed:
                    'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-400',
                groupLabelSelected: 'bg-green-500 text-white',
                groupLabelDisabled:
                    'bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-500 cursor-not-allowed',
                groupLabelSelectedPointed: 'bg-green-600 text-white opacity-90',
                groupLabelSelectedDisabled:
                    'text-green-100 bg-green-600 bg-opacity-50 cursor-not-allowed',
                groupOptions: 'p-0 m-0',
                option: 'flex items-center justify-start box-border text-left cursor-pointer text-sm dark:text-gray-400 leading-snug py-2 px-3',
                optionPointed:
                    'text-gray-800 dark:text-gray-400 bg-gray-100 dark:bg-dark-body',
                optionSelected:
                    'text-white dark:text-gray-400 bg-primary dark:bg-black',
                optionDisabled:
                    'text-gray-300 dark:text-gray-400 cursor-not-allowed',
                optionSelectedPointed:
                    'text-white dark:text-gray-400 bg-dark-primary dark:bg-black opacity-90',
                optionSelectedDisabled:
                    'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                noOptions:
                    'py-2 px-3 text-gray-600 dark:text-gray-400 bg-white dark:bg-dark-body text-left rtl:text-right',
                noResults:
                    'py-2 px-3 text-gray-600 dark:text-gray-400 bg-white dark:bg-dark-body text-left rtl:text-right',
                fakeInput:
                    'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent focus:ring-0',
                assist: 'absolute -m-px w-px h-px overflow-hidden',
                spacer: 'h-9 py-px box-content',
            }"
        >
            <template #singlelabel="{ value }">
                <div
                    v-if="$slots.selectedOption"
                    class="pointer-events-none absolute left-0 top-0 flex h-full items-center bg-transparent pl-3.5 leading-snug"
                >
                    <slot name="selectedOption" :value="value"></slot>
                </div>
            </template>

            <template #option="{ option }">
                <slot name="listOption" :option="option"></slot>
            </template>
        </Multiselect>
    </div>
    <FormError :error="error" />
</template>

<script>
export default {
    name: "BaseSelect",
    inheritAttrs: false,
}
</script>

<script setup>
import { onMounted, reactive, computed, watch, useSlots } from "vue"
import Multiselect from "@vueform/multiselect"

const emit = defineEmits([
    "update:modelValue",
    "update:error",
    "selected",
    "removed",
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
        type: [String, Object, Number, Boolean, Array],
        default: "",
    },
    options: {
        type: [Array, Function],
        default: [],
    },
    error: {
        type: String,
        default: "",
    },
    searchable: {
        type: Boolean,
        default: true,
    },
    labelProp: {
        type: String,
        default: "label",
    },
    valueProp: {
        type: String,
        default: "value",
    },
    objectProp: {
        type: Boolean,
        default: false,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    tags: {
        type: Boolean,
        default: false,
    },
    minWidth: {
        type: Boolean,
        default: false,
    },
    invisible: {
        type: Boolean,
        default: false,
    },
})

const slots = useSlots()

const state = reactive({
    uniqueId: "",
    input: props.modelValue,
})

const updateInput = (value) => {
    emit("update:modelValue", value)
    emit("update:error", "")
}

const selected = (option, $select) => {
    emit("selected", $select)
}

const removed = (option, $select) => {
    emit("removed", $select)
}

const getMode = computed(() => {
    if (props.multiple) {
        return "multiple"
    } else if (props.tags) {
        return "tags"
    }

    return "single"
})

watch(
    () => props.modelValue,
    (value) => {
        state.input = value
    }
)

onMounted(() => {
    state.uniqueId = props.id || Math.random().toString(16).slice(2)
})
</script>
