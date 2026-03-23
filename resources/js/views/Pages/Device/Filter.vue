<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('device.props.name')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('device.props.code')"
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive } from "vue"

const emit = defineEmits(["hide"])

const initForm = {
    name: "",
    code: "",
}

const form = reactive({ ...initForm })
</script>
