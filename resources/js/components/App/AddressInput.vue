<template>
    <div class="col-span-3 sm:col-span-1">
        <BaseInput
            type="text"
            v-model="address.addressLine1"
            :name="getName('addressLine1')"
            :label="
                $trans('contact.props.address.address_line1')
            "
            v-model:error="formErrors[getName('addressLine1')]"
            @input="$emit('update:addressLine1', $event.target.value)"
        />
    </div>
    <div class="col-span-3 sm:col-span-1">
        <BaseInput
            type="text"
            v-model="address.addressLine2"
            :name="getName('addressLine2')"
            :label="
                $trans('contact.props.address.address_line2')
            "
            v-model:error="formErrors[getName('addressLine2')]"
            @input="$emit('update:addressLine2', $event.target.value)"
        />
    </div>
    <div class="col-span-3 sm:col-span-1">
        <BaseInput
            type="text"
            v-model="address.city"
            :name="getName('city')"
            :label="
                $trans('contact.props.address.city')
            "
            v-model:error="formErrors[getName('city')]"
            @input="$emit('update:city', $event.target.value)"
        />
    </div>
    <div class="col-span-3 sm:col-span-1">
        <BaseInput
            type="text"
            v-model="address.state"
            :name="getName('state')"
            :label="
                $trans('contact.props.address.state')
            "
            v-model:error="formErrors[getName('state')]"
            @input="$emit('update:state', $event.target.value)"
        />
    </div>
    <div class="col-span-3 sm:col-span-1">
        <BaseInput
            type="text"
            v-model="address.zipcode"
            :name="getName('zipcode')"
            :label="
                $trans('contact.props.address.zipcode')
            "
            v-model:error="formErrors[getName('zipcode')]"
            @input="$emit('update:zipcode', $event.target.value)"
        />
    </div>
    <div class="col-span-3 sm:col-span-1">
        <BaseInput
            type="text"
            v-model="address.country"
            :name="getName('country')"
            :label="
                $trans('contact.props.address.country')
            "
            v-model:error="formErrors[getName('country')]"
            @input="$emit('update:country', $event.target.value)"
        />
    </div>
</template>

<script>
export default {
    name: 'AddressInput',
}
</script>

<script setup>
import { onMounted, reactive, watch } from 'vue'

const props = defineProps({
    addressLine1: {
        type: String,
        default: ''
    },
    addressLine2: {
        type: String,
        default: ''
    },
    prefix: {
        type: String,
        default: ''
    },
    city: {
        type: String,
        default: ''
    },
    state: {
        type: String,
        default: ''
    },
    zipcode: {
        type: String,
        default: ''
    },
    country: {
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

const address = reactive({
    addressLine1: '',
    addressLine2: '',
    city: '',
    state: '',
    zipcode: '',
    country: '',
})

const getName = (name) => {
    if (props.prefix) {
        return props.prefix + name[0].toUpperCase() + name.slice(1)
    }

    return name
}

onMounted(() => {
    address.addressLine1 = props.addressLine1
    address.addressLine2 = props.addressLine2
    address.city = props.city
    address.state = props.state
    address.zipcode = props.zipcode
    address.country = props.country
})

watch(
    () => [props.addressLine1, props.addressLine2, props.city, props.state, props.zipcode, props.country],
    (value) => {
        address.addressLine1 = value[0]
        address.addressLine2 = value[1]
        address.city = value[2]
        address.state = value[3]
        address.zipcode = value[4]
        address.country = value[5]
    }
)
</script>
