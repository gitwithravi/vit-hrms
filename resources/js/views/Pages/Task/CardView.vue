<template>
    <CardList :header="tasks.headers" :meta="tasks.meta" module="task">
        <div
            class="grid grid-cols-1 gap-4 px-4 pt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <template v-for="task in tasks.data" :key="task.uuid">
                <CardView
                    :path="{ name: 'TaskShow', params: { uuid: task.uuid } }"
                >
                    <template #title>
                        <div>{{ task.codeNumber }}</div>
                        <div class="w-4/5 truncate">{{ task.title }}</div>
                    </template>

                    <template #action>
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
                                    perform('task:edit') &&
                                    task.permission?.isEditable
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
                                >{{
                                    $trans("general.delete")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </template>

                    <p class="text-xs text-gray-500">
                        <span v-if="task.owner">
                            {{ task.owner.name }} -
                            {{ task.owner.designation }} @
                            {{ task.owner.branch }}
                        </span>
                    </p>
                    <p class="truncate text-sm text-gray-500">
                        <BaseBadge
                            :design="task.priority?.color ? 'custom' : ''"
                            :color="task.priority?.color"
                            >{{ task.priority?.name }}</BaseBadge
                        >
                        <BaseBadge
                            :design="task.category?.color ? 'custom' : ''"
                            :color="task.category?.color"
                            >{{ task.category?.name }}</BaseBadge
                        >
                    </p>
                    <div class="space-x-2 text-sm text-gray-500">
                        <span>{{ task.due.formatted }}</span>
                        <span
                            v-if="task.isOverdue"
                            v-tooltip="task.overdueDaysDisplay"
                        >
                            <i class="fas fa-calendar text-warning"></i>
                        </span>
                        <span v-if="task.isCompleted">
                            <i
                                class="fas fa-check-circle fa-lg text-success"
                            ></i>
                        </span>
                    </div>
                    <div class="space-x-2 text-sm text-gray-500">
                        <span
                            v-if="task.isOwner"
                            v-tooltip="$trans('task.props.owner')"
                        >
                            <i
                                class="fas fa-crown fa-lg text-primary dark:text-gray-400"
                            ></i>
                        </span>
                        <span
                            v-if="!task.isOwner && task.isMember"
                            v-tooltip="$trans('task.member.member')"
                        >
                            <i
                                class="fas fa-user fa-lg text-primary dark:text-gray-400"
                            ></i>
                        </span>
                        <span
                            v-if="task.isArchived"
                            v-tooltip="$trans('general.archived')"
                        >
                            <i
                                class="fas fa-box-archive fa-lg text-primary dark:text-gray-400"
                            ></i>
                        </span>
                        <span
                            v-if="task.isFavorite"
                            v-tooltip="$trans('task.props.favorite')"
                        >
                            <i class="fas fa-star fa-lg text-warning"></i>
                        </span>
                        <span
                            v-if="
                                task.shouldRepeat &&
                                task.repeatation?.nextRepeatDate.formatted
                            "
                            v-tooltip="
                                $trans('task.repeat.props.next_repeat_date') +
                                ': ' +
                                task.repeatation?.nextRepeatDate.formatted
                            "
                        >
                            <i class="fas fa-repeat fa-lg text-info"></i>
                        </span>
                        <span
                            v-if="task.isCancelled"
                            v-tooltip="$trans('general.cancelled')"
                        >
                            <i class="fas fa-ban fa-lg text-danger"></i>
                        </span>
                    </div>
                    <template #progress>
                        <ProgressBar
                            v-if="task.hasProgress"
                            :percent="task.progress"
                            :color="task.progressColor"
                            bg-color="transparent"
                        />
                    </template>
                </CardView>
            </template>
        </div>
        <div>
            <Pagination
                card-view
                :meta="tasks.meta"
                @refresh="emitter.emit('listItems')"
            ></Pagination>
        </div>
        <template #actionButton>
            <BaseButton
                v-if="perform('task:create')"
                @click="router.push({ name: 'TaskCreate' })"
            >
                {{ $trans("global.add", { attribute: $trans("task.task") }) }}
            </BaseButton>
        </template>
    </CardList>
</template>

<script>
export default {
    name: "TaskListCardView",
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
