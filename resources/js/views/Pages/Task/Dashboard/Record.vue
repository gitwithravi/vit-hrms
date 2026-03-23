<template>
    <div class="col-span-1">
        <BaseCard no-padding no-content-padding>
            <template #title>
                {{ state.label }}
            </template>

            <template #action>
                <DropdownButton direction="down" :label="state.label">
                    <template v-for="taskType in state.types">
                        <DropdownItem as="span" @click="type = taskType.value">
                            {{ taskType.label }}
                        </DropdownItem>
                    </template>
                </DropdownButton>
            </template>

            <SimpleTable :header="detailHeader" v-if="state.tasks.length > 0">
                <DataRow v-for="task in state.tasks" :key="task.uuid">
                    <DataCell name="codeNumber">
                        {{ task.codeNumber }})
                    </DataCell>
                    <DataCell name="title">
                        {{ task.title }}
                    </DataCell>
                    <DataCell name="priority">
                        <BaseBadge
                            :design="task.priority?.color ? 'custom' : ''"
                            :color="task.priority?.color"
                            >{{ task.priority?.name }}</BaseBadge
                        >
                    </DataCell>
                    <DataCell name="category">
                        <BaseBadge
                            :design="task.category?.color ? 'custom' : ''"
                            :color="task.category?.color"
                            >{{ task.category?.name }}</BaseBadge
                        >
                    </DataCell>
                    <DataCell name="owner">
                        {{ task.owner.name }}
                        <div class="text-xs">
                            {{ task.owner.designation }} @
                            {{ task.owner.branch }}
                        </div>
                    </DataCell>
                    <DataCell name="startDate">
                        {{ task.startDate.formatted }}
                    </DataCell>
                    <DataCell name="due">
                        {{ task.due.formatted }}
                    </DataCell>
                </DataRow>
            </SimpleTable>

            <div class="p-2" v-if="state.tasks.length == 0">
                <BaseAlert size="xs" design="info">{{
                    $trans("general.errors.record_not_found")
                }}</BaseAlert>
            </div>
        </BaseCard>
    </div>
</template>

<script>
export default {
    name: "TaskDashboardRecord",
}
</script>

<script setup>
import { onMounted, reactive, ref, inject, watch } from "vue"
import { useStore } from "vuex"

const $trans = inject("$trans")

const store = useStore()

const isLoading = ref(false)
const type = ref("")
const state = reactive({
    tasks: [],
    types: [],
    label: "",
})

const detailHeader = [
    {
        key: "codeNumber",
        label: $trans("task.props.code_number"),
        visibility: true,
    },
    { key: "title", label: $trans("task.props.title"), visibility: true },
    {
        key: "priority",
        label: $trans("task.priority.priority"),
        visibility: true,
    },
    {
        key: "category",
        label: $trans("task.category.category"),
        visibility: true,
    },
    { key: "owner", label: $trans("task.props.owner"), visibility: true },
    {
        key: "startDate",
        label: $trans("task.props.start_date"),
        visibility: true,
    },
    { key: "due", label: $trans("task.props.due_date"), visibility: true },
]

const getTasks = async () => {
    isLoading.value = true

    await store
        .dispatch("task/dashboard/getRecord", { type: type.value })
        .then((response) => {
            isLoading.value = false
            Object.assign(state, response)
        })
        .catch((e) => {
            isLoading.value = false
        })
}

watch(
    () => type.value,
    () => getTasks()
)

onMounted(async () => {
    await getTasks()
})
</script>
