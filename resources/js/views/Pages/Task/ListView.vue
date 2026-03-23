<template>
    <DataTable
        :header="tasks.headers"
        :meta="tasks.meta"
        module="task"
        @refresh="emitter.emit('listItems')"
    >
        <DataRow v-for="task in tasks.data" :key="task.uuid">
            <DataCell name="codeNumber">
                {{ task.codeNumber }}
            </DataCell>
            <DataCell name="title">
                <span class="truncate">{{ task.title }}</span>
                <ProgressBar
                    space
                    v-if="task.hasProgress"
                    :percent="task.progress"
                    :color="task.progressColor"
                />
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
                <span v-if="task.owner">
                    {{ task.owner.name }}
                    <div class="text-xs">
                        {{ task.owner.designation }} @ {{ task.owner.branch }}
                    </div>
                </span>
                <span v-else>-</span>
            </DataCell>
            <DataCell name="due">
                <div class="space-x-2">
                    <span>{{ task.due.formatted }}</span>
                    <span
                        v-if="task.isOverdue"
                        v-tooltip="task.overdueDaysDisplay"
                    >
                        <i class="fas fa-calendar text-warning"></i>
                    </span>
                    <span v-if="task.isCompleted">
                        <i class="fas fa-check-circle fa-lg text-success"></i>
                    </span>
                </div>
            </DataCell>
            <DataCell name="createdAt">
                {{ task.createdAt.formatted }}
            </DataCell>
            <DataCell name="action">
                <FloatingMenu>
                    <FloatingMenuItem
                        icon="fas fa-arrow-circle-right"
                        @click="
                            router.push({
                                name: 'TaskShow',
                                params: { uuid: task.uuid },
                            })
                        "
                        >{{ $trans("general.show") }}</FloatingMenuItem
                    >
                    <FloatingMenuItem
                        v-if="
                            perform('task:edit') && task.permission?.isEditable
                        "
                        icon="fas fa-edit"
                        @click="
                            router.push({
                                name: 'TaskEdit',
                                params: { uuid: task.uuid },
                            })
                        "
                        >{{ $trans("general.edit") }}</FloatingMenuItem
                    >
                    <FloatingMenuItem
                        v-if="
                            perform('task:delete') &&
                            task.permission?.isDeletable
                        "
                        icon="fas fa-trash"
                        @click="
                            emitter.emit('deleteItem', {
                                uuid: task.uuid,
                            })
                        "
                        >{{ $trans("general.delete") }}</FloatingMenuItem
                    >
                </FloatingMenu>
            </DataCell>
        </DataRow>
        <template #actionButton>
            <BaseButton
                v-if="perform('task:create')"
                @click="router.push({ name: 'TaskCreate' })"
            >
                {{ $trans("global.add", { attribute: $trans("task.task") }) }}
            </BaseButton>
        </template>
    </DataTable>
</template>

<script>
export default {
    name: "TaskListView",
}
</script>

<script setup>
import { inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const props = defineProps({
    tasks: {
        type: Object,
        default: () => ({}),
    },
})
</script>
