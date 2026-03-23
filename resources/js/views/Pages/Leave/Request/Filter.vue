<template>
    <FilterForm
        :init-form="initForm"
        :form="form"
        :multiple="['employees', 'leaveTypes']"
        @hide="emit('hide')"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="employees"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('employee.employee'),
                        })
                    "
                    v-model="form.employees"
                    value-prop="uuid"
                    :init-search="fetchData.employees"
                    search-key="name"
                    search-action="employee/list"
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
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="leaveTypes"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('leave.type.type'),
                        })
                    "
                    v-model="form.leaveTypes"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.leaveTypes"
                    search-key="name"
                    search-action="leave/type/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model:start="form.startDate"
                    v-model:end="form.endDate"
                    name="dateBetween"
                    as="range"
                    :label="$trans('general.date_between')"
                />
            </div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()

const emit = defineEmits(["hide"])

const initForm = {
    employees: [],
    leaveTypes: [],
    startDate: "",
    endDate: "",
}

const form = reactive({ ...initForm })

const fetchData = reactive({
    employees: [],
    leaveTypes: [],
    isLoaded: route.query.employees || route.query.leaveTypes ? false : true,
})

onMounted(async () => {
    fetchData.employees = route.query.employees
        ? route.query.employees.split(",")
        : []
    fetchData.leaveTypes = route.query.leaveTypes
        ? route.query.leaveTypes.split(",")
        : []
    fetchData.isLoaded = true
})
</script>
