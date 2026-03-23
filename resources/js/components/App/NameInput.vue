<template>
    <BaseInput
        type="text"
        v-model="form.firstName"
        name="firstName"
        :placeholder="$trans('contact.props.first_name')"
        v-model:error="formErrors.firstName"
        adjacent-left
        @input="$emit('update:firstName', $event.target.value)"
    />
    <BaseInput
        v-if="hasMiddleName"
        type="text"
        v-model="form.middleName"
        name="middleName"
        :placeholder="$trans('contact.props.middle_name')"
        v-model:error="formErrors.middleName"
        adjacent-center
        @input="$emit('update:middleName', $event.target.value)"
    />
    <BaseInput
        v-if="hasThirdName"
        type="text"
        v-model="form.thirdName"
        name="thirdName"
        :placeholder="$trans('contact.props.third_name')"
        v-model:error="formErrors.thirdName"
        adjacent-center
        @input="$emit('update:thirdName', $event.target.value)"
    />
    <BaseInput
        type="text"
        v-model="form.lastName"
        name="lastName"
        :placeholder="$trans('contact.props.last_name')"
        v-model:error="formErrors.lastName"
        adjacent-right
        @input="$emit('update:lastName', $event.target.value)"
    />
</template>

<script>
export default {
    name: 'NameInput',
}
</script>


<script setup>
import { computed, reactive, onMounted, watch } from "vue"
import { useStore } from "vuex"

const store = useStore()

const props = defineProps({
    firstName: {
        type: String,
        default: ''
    },
    middleName: {
        type: String,
        default: ''
    },
    thirdName: {
        type: String,
        default: ''
    },
    lastName: {
        type: String,
        default: ''
    },
    formErrors: {
        type: Object,
        default() {
            return {}
        }
    }
})

const form = reactive({
    firstName: '',
    middleName: '',
    thirdName: '',
    lastName: '',
})

const hasMiddleName = computed(() => store.getters['config/config']('employee.enableMiddleNameField'))
const hasThirdName = computed(() => store.getters['config/config']('employee.enableThirdNameField'))

onMounted(() => {
    form.firstName = props.firstName
    form.middleName = props.middleName
    form.thirdName = props.thirdName
    form.lastName = props.lastName
})

watch(
    () => [props.firstName, props.middleName, props.thirdName, props.lastName],
    (value) => {
        form.firstName = value[0]
        form.middleName = value[1]
        form.thirdName = value[2]
        form.lastName = value[3]
    }
)
</script>
