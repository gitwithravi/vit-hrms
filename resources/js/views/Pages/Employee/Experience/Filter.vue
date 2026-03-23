<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.headline"
                    name="headline"
                    :label="$trans('employee.experience.props.headline')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.location"
                    name="location"
                    :label="$trans('employee.experience.props.location')"
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive } from "vue"

const emit = defineEmits(["hide"])

const initForm = {
    headline: "",
    location: "",
}

const form = reactive({ ...initForm })
</script>
