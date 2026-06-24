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
import { reactive, onMounted } from "vue"
import { useRoute } from "vue-router"

defineProps({
    preRequisites: {
        type: Object,
        default() {
            return {}
        },
    },
})

const route = useRoute()

const emit = defineEmits(["hide"])

const initForm = {
    employees: [],
    name: "",
    relationship: "",
    gender: "",
    topUp: "",
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
