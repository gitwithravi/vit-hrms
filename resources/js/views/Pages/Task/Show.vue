<template>
    <PageHeader
        v-if="task.uuid"
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('task.task'), path: 'TaskList' },
            {
                label: task.codeNumber,
                path: {
                    name: 'TaskShow',
                    params: { uuid: task.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="Task"
            :title="$trans('task.task')"
            :actions="userActions"
        >
            <template v-if="!task.isCompleted">
                <BaseButton
                    design="white"
                    v-if="
                        route.name == 'TaskChecklistList' &&
                        task.permission?.manageChecklist
                    "
                    @click="emitter.emit('addTaskChecklist')"
                >
                    {{
                        $trans("global.add", {
                            attribute: $trans("task.checklist.checklist"),
                        })
                    }}
                </BaseButton>

                <BaseButton
                    design="white"
                    v-if="
                        route.name == 'TaskMemberList' &&
                        task.permission?.manageMember
                    "
                    @click="emitter.emit('addTaskMember')"
                >
                    {{
                        $trans("global.add", {
                            attribute: $trans("task.member.member"),
                        })
                    }}
                </BaseButton>

                <BaseButton
                    design="white"
                    v-if="
                        route.name == 'TaskMediaList' &&
                        task.permission?.manageMedia
                    "
                    @click="emitter.emit('addTaskMedia')"
                >
                    {{
                        $trans("global.add", {
                            attribute: $trans("task.media.media"),
                        })
                    }}
                </BaseButton>
            </template>

            <template #dropdown>
                <DropdownItem
                    icon="fas fa-pencil"
                    v-if="perform('task:edit') && task.permission?.isEditable"
                    @click="
                        router.push({
                            name: 'TaskEdit',
                            params: { uuid: task.uuid },
                        })
                    "
                    >{{
                        $trans("global.edit", {
                            attribute: $trans("task.task"),
                        })
                    }}</DropdownItem
                >
                <DropdownItem
                    icon="fas fa-trash"
                    v-if="
                        perform('task:delete') && task.permission?.isDeletable
                    "
                    @click="
                        emitter.emit('showDeleteItem', {
                            uuid: task.uuid,
                        })
                    "
                    >{{
                        $trans("global.delete", {
                            attribute: $trans("task.task"),
                        })
                    }}</DropdownItem
                >
            </template>
        </PageHeaderAction>
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'Task' })"
            :refresh="refreshItem"
            @refreshed="refreshItem = false"
        >
            <BaseTab
                v-if="task"
                :tabs="[
                    {
                        name: 'TaskShowGeneral',
                        icon: 'fas fa-home',
                        label: $trans('general.detail'),
                        path: 'TaskShowGeneral',
                    },
                    {
                        name: 'TaskMember',
                        icon: 'fas fa-users',
                        label: $trans('task.member.member'),
                        count: task.memberCount,
                        path: 'TaskMemberList',
                    },
                    {
                        name: 'TaskChecklist',
                        icon: 'fas fa-list',
                        label: $trans('task.checklist.checklist'),
                        count: task.checklistCount,
                        path: 'TaskChecklistList',
                    },
                    {
                        name: 'TaskMedia',
                        icon: 'fas fa-paperclip',
                        label: $trans('task.media.media'),
                        count: task.mediaCount,
                        path: 'TaskMediaList',
                    },
                    {
                        name: 'TaskRepeat',
                        icon: 'fas fa-repeat',
                        label: $trans('task.repeat.repeat'),
                        path: 'TaskRepeatList',
                    },
                ]"
            />

            <BaseCard v-if="task.uuid">
                <template #title>
                    <span
                        v-if="task.permission?.toggleFavorite"
                        class="cursor-pointer"
                        @click="
                            emitter.emit('showActionItem', {
                                uuid: task.uuid,
                                action: 'toggleFavorite',
                                confirmation: true,
                            })
                        "
                    >
                        <i
                            class="fas fa-star text-warning"
                            v-if="task.isFavorite"
                        ></i>
                        <i class="fa-regular fa-star text-warning" v-else></i>
                    </span>
                    #{{ task.codeNumber }} - {{ task.title }}
                    <span class="ml-2 space-x-2">
                        <i
                            class="fas fa-box-archive text-primary dark:text-gray-400"
                            v-if="task.isArchived"
                            v-tooltip="$trans('general.archived')"
                        ></i>
                        <i
                            class="fas fa-ban text-danger"
                            v-if="task.isCancelled"
                            v-tooltip="$trans('general.cancelled')"
                        ></i>
                        <i
                            class="fas fa-rotate-right text-info cursor-pointer"
                            v-if="task.repeatedTaskUuid"
                            @click="
                                router.push({
                                    name: 'TaskShow',
                                    params: { uuid: task.repeatedTaskUuid },
                                })
                            "
                            v-tooltip="$trans('task.repeat.repeated_task')"
                        ></i>
                    </span>
                </template>
                <template #action>
                    <div class="space-x-2">
                        <BaseButton
                            size="xs"
                            design="success"
                            v-if="task.permission?.markAsComplete"
                            @click="
                                emitter.emit('showActionItem', {
                                    uuid: task.uuid,
                                    action: 'status',
                                    data: { status: 'complete' },
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.mark", {
                                    attribute: $trans("task.statuses.complete"),
                                })
                            }}</BaseButton
                        >

                        <BaseButton
                            size="xs"
                            design="danger"
                            v-if="task.permission?.markAsCancel"
                            @click="
                                emitter.emit('showActionItem', {
                                    uuid: task.uuid,
                                    action: 'status',
                                    data: { status: 'cancel' },
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.mark", {
                                    attribute: $trans("task.statuses.cancel"),
                                })
                            }}</BaseButton
                        >

                        <BaseButton
                            size="xs"
                            design="success"
                            v-if="task.permission?.markAsActive"
                            @click="
                                emitter.emit('showActionItem', {
                                    uuid: task.uuid,
                                    action: 'status',
                                    data: { status: 'active' },
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.mark", {
                                    attribute: $trans("task.statuses.active"),
                                })
                            }}</BaseButton
                        >

                        <BaseButton
                            size="xs"
                            design="danger"
                            v-if="task.permission?.markAsIncomplete"
                            @click="
                                emitter.emit('showActionItem', {
                                    uuid: task.uuid,
                                    action: 'status',
                                    data: { status: 'incomplete' },
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.mark", {
                                    attribute: $trans(
                                        "task.statuses.incomplete"
                                    ),
                                })
                            }}</BaseButton
                        >

                        <BaseButton
                            size="xs"
                            v-if="task.permission?.moveToArchive"
                            @click="
                                emitter.emit('showActionItem', {
                                    uuid: task.uuid,
                                    action: 'status',
                                    data: { status: 'archive' },
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.move_to", {
                                    attribute: $trans("general.archive"),
                                })
                            }}</BaseButton
                        >

                        <BaseButton
                            size="xs"
                            v-if="task.permission?.moveFromArchive"
                            @click="
                                emitter.emit('showActionItem', {
                                    uuid: task.uuid,
                                    action: 'status',
                                    data: { status: 'unarchive' },
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.move_from", {
                                    attribute: $trans("general.archive"),
                                })
                            }}</BaseButton
                        >
                    </div>
                </template>

                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-4">
                    <BaseDataView :label="$trans('task.category.category')">
                        <template v-if="task.category">
                            <BaseBadge
                                :design="task.category.color ? 'custom' : ''"
                                :color="task.category.color"
                                >{{ task.category.name }}</BaseBadge
                            >
                        </template>
                    </BaseDataView>

                    <BaseDataView :label="$trans('task.priority.priority')">
                        <template v-if="task.priority">
                            <BaseBadge
                                :design="task.priority.color ? 'custom' : ''"
                                :color="task.priority.color"
                                >{{ task.priority.name }}</BaseBadge
                            >
                        </template>
                    </BaseDataView>

                    <BaseDataView :label="$trans('task.props.start_date')">
                        {{ task.startDate.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('task.props.due_date')">
                        {{ task.due.formatted }}
                        <i
                            class="fas fa-check-circle fa-lg text-success"
                            v-if="task.isCompleted"
                        ></i>
                        <BaseBadge design="danger" v-if="task.isOverdue">{{
                            task.overdueDaysDisplay
                        }}</BaseBadge>
                    </BaseDataView>

                    <TagList :task="task" @refresh="refreshItem = true" />

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('task.props.owner')"
                        v-if="task.owner"
                    >
                        <EmployeeSummary :employee="task.owner" />
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ task.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ task.updatedAt.formatted }}
                    </BaseDataView>
                </dl>

                <template #progress>
                    <ProgressBar
                        rounded
                        v-if="task.hasProgress"
                        height="h-2"
                        bg-color="transparent"
                        :percent="task.progress"
                        :color="task.progressColor"
                    />
                </template>
            </BaseCard>

            <router-view
                v-if="task.uuid"
                :task="task"
                @refresh="refreshItem = true"
            />
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "TaskShow",
}
</script>

<script setup>
import { reactive, ref, watch, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform, getFormErrors } from "@core/helpers/action"
import TagList from "./TagList.vue"

const store = useStore()
const route = useRoute()
const router = useRouter()

const $trans = inject("$trans")
const emitter = inject("emitter")

let userActions = ["list"]

const initialTask = {}

const initForm = {
    status: "",
    comment: "",
}

const initUrl = "task/"
const preRequisites = reactive({})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const refreshItem = ref(false)
const task = reactive({ ...initialTask })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setItem = (data) => {
    Object.assign(task, data)
}

const afterSubmit = () => {
    refreshItem.value = true
}

watch(
    () => route.params.uuid,
    (value) => {
        refreshItem.value = true
    }
)
</script>
