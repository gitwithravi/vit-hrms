<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('employee.mediclaim.props.name')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.relationship"
                    name="relationship"
                    :label="$trans('employee.mediclaim.props.relationship')"
                    :options="preRequisites.relationships"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.gender"
                    name="gender"
                    :label="$trans('employee.mediclaim.props.gender')"
                    :options="preRequisites.genders"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    v-model="form.topUp"
                    name="topUp"
                    :label="$trans('employee.mediclaim.props.top_up')"
                    :options="preRequisites.topUpOptions"
                />
            </div>
        </div>
    </FilterForm>
</template>

<script>
export default {
    name: "MediclaimDependantFilter",
}
</script>

<script setup>
import { reactive } from "vue"

defineProps({
    preRequisites: {
        type: Object,
        default() {
            return {}
        },
    },
})

const emit = defineEmits(["hide"])

const initForm = {
    name: "",
    relationship: "",
    gender: "",
    topUp: "",
}

const form = reactive({ ...initForm })
</script>
