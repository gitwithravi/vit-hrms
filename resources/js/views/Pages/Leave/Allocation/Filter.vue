<template>
    <FilterForm
        :init-form="initForm"
        :form="form"
        :multiple="['employees']"
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
    startDate: "",
    endDate: "",
}

const form = reactive({ ...initForm })

const fetchData = reactive({
    employees: [],
    isLoaded: route.query.employees ? false : true,
})

onMounted(async () => {
    fetchData.employees = route.query.employees
        ? route.query.employees.split(",")
        : []
    fetchData.isLoaded = true
})
</script>
