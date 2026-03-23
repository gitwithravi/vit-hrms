<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="employee"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('employee.employee'),
                        })
                    "
                    v-model="form.employee"
                    value-prop="uuid"
                    :init-search="fetchData.employee"
                    :additional-search-query="{ self: 0 }"
                    search-action="employee/list"
                    v-model:error="formErrors.employee"
                >
                    <template #selectedOption="slotProps">
                        {{ slotProps.value.name }} ({{
                            slotProps.value.codeNumber
                        }})
                    </template>

                    <template #listOption="slotProps">
                        {{ slotProps.option.name }} ({{
                            slotProps.option.codeNumber
                        }})
                    </template>
                </BaseSelectSearch>
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model:start="form.startDate"
                    v-model:end="form.endDate"
                    name="dateBetween"
                    as="range"
                    :label="$trans('payroll.props.period')"
                    v-model:error="formErrors.startDate"
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive, inject, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const moment = inject("moment")

const emit = defineEmits(["hide"])

const props = defineProps({
    initUrl: {
        type: String,
        default: "",
    },
})

const initForm = {
    employee: "",
    startDate: "",
    endDate: "",
}

const form = reactive({ ...initForm })
const formErrors = getFormErrors(props.initUrl)

const fetchData = reactive({
    employee: "",
    isLoaded: route.query.employee ? false : true,
})

onMounted(async () => {
    fetchData.employee = route.query.employee
    fetchData.isLoaded = true
})
</script>
