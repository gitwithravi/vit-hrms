<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.course"
                    name="course"
                    :label="$trans('employee.qualification.props.course')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.institute"
                    name="institute"
                    :label="$trans('employee.qualification.props.institute')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.affiliatedTo"
                    name="affiliatedTo"
                    :label="
                        $trans('employee.qualification.props.affiliated_to')
                    "
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive } from "vue"

const emit = defineEmits(["hide"])

const initForm = {
    course: "",
    institute: "",
    affiliatedTo: "",
}

const form = reactive({ ...initForm })
</script>
