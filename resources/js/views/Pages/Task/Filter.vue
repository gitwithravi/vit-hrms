<template>
    <FilterForm
        :init-form="initForm"
        :form="form"
        :multiple="[
            'employees',
            'categories',
            'priorities',
            'tagsIncluded',
            'tagsExcluded',
        ]"
        @hide="emit('hide')"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.codeNumber"
                    name="codeNumber"
                    :label="$trans('task.props.code_number')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.title"
                    name="title"
                    :label="$trans('task.props.title')"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="categories"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('task.category.category'),
                        })
                    "
                    v-model="form.categories"
                    value-prop="uuid"
                    :init-search="fetchData.categories"
                    search-action="option/list"
                    :additional-search-query="{ type: 'task_category' }"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    multiple
                    v-if="fetchData.isLoaded"
                    name="priorities"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('task.priority.priority'),
                        })
                    "
                    v-model="form.priorities"
                    value-prop="uuid"
                    :init-search="fetchData.priorities"
                    search-action="option/list"
                    :additional-search-query="{ type: 'task_priority' }"
                />
            </div>
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
                    name="startDateBetween"
                    as="range"
                    :label="
                        $trans('global.date_between', {
                            attribute: $trans('task.props.start_date'),
                        })
                    "
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model:start="form.dueStartDate"
                    v-model:end="form.dueEndDate"
                    name="dueDateBetween"
                    as="range"
                    :label="
                        $trans('global.date_between', {
                            attribute: $trans('task.props.due_date'),
                        })
                    "
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseSelectSearch
                    tags
                    v-if="fetchData.isLoaded"
                    name="tagsIncluded"
                    :label="$trans('general.tags_included')"
                    v-model="form.tagsIncluded"
                    :init-search="fetchData.tagsIncluded"
                    search-action="tag/list"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseSelectSearch
                    tags
                    v-if="fetchData.isLoaded"
                    name="tagsExcluded"
                    :label="$trans('general.tags_excluded')"
                    v-model="form.tagsExcluded"
                    :init-search="fetchData.tagsExcluded"
                    search-action="tag/list"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <BaseSwitch
                    vertical
                    v-model="form.isArchived"
                    name="isArchived"
                    :label="$trans('general.archived')"
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
    codeNumber: "",
    title: "",
    categories: [],
    priorities: [],
    employees: [],
    startDate: "",
    endDate: "",
    dueStartDate: "",
    dueEndDate: "",
    tagsIncluded: [],
    tagsExcluded: [],
    isArchived: false,
}

const form = reactive({ ...initForm })

const fetchData = reactive({
    employees: [],
    categories: [],
    priorities: [],
    tagsIncluded: [],
    tagsExcluded: [],
    isLoaded:
        route.query.employees ||
        route.query.categories ||
        route.query.priorities ||
        route.query.tagsIncluded ||
        route.query.tagsExcluded
            ? false
            : true,
})

onMounted(async () => {
    fetchData.employees = route.query.employees
        ? route.query.employees.split(",")
        : []
    fetchData.categories = route.query.categories
        ? route.query.categories.split(",")
        : []
    fetchData.priorities = route.query.priorities
        ? route.query.priorities.split(",")
        : []
    fetchData.tagsIncluded = route.query.tagsIncluded
        ? route.query.tagsIncluded.split(",")
        : []
    fetchData.tagsExcluded = route.query.tagsExcluded
        ? route.query.tagsExcluded.split(",")
        : []
    fetchData.isLoaded = true
})
</script>
