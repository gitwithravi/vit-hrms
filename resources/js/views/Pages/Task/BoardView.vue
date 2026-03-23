<template>
    <KanBanView :add-list="perform('task:config') ? true : false">
        <template #addListTitle>
            {{ $trans("global.add", { attribute: $trans("task.list.list") }) }}
        </template>
        <template #addListForm>
            <TaskListForm @completed="newListAdded" />
        </template>
        <draggable
            class="flex space-x-2"
            :list="state.lists"
            @change="listChange"
            item-key="uuid"
            :disabled="perform('task:config') ? false : true"
        >
            <template #item="{ element }">
                <div
                    class="flex h-[calc(100vh_-_250px)] w-80 flex-shrink-0 flex-col rounded-md bg-gray-100 p-3 dark:bg-neutral-800"
                >
                    <h3
                        class="flex-shrink-0 text-sm font-medium text-gray-900 dark:text-gray-300"
                        :class="{
                            'cursor-move': perform('task:config')
                                ? true
                                : false,
                        }"
                    >
                        {{ element.name }}
                    </h3>
                    <div class="scroller-thin-y scroller-hidden min-h-0 flex-1">
                        <draggable
                            class="mt-2 space-y-3"
                            :list="element.items"
                            group="items"
                            @change="itemChange"
                            item-key="uuid"
                        >
                            <template #header>
                                <div
                                    class="mt-2 rounded-md border-2 border-dashed border-gray-400 p-2 text-sm text-gray-400 dark:border-gray-500 dark:text-gray-500"
                                    v-if="element.items.length === 0"
                                >
                                    {{ $trans("task.list.info_empty") }}
                                </div>
                            </template>
                            <template #item="{ element }">
                                <div
                                    class="dark:bg-dark-body rounded-md border-2 bg-white text-gray-700 shadow-sm dark:text-gray-400"
                                    :class="{
                                        'border-success': element.isCompleted,
                                        'border-danger': element.isOverdue,
                                        'border-warning': element.isDueToday,
                                        'border-gray-400':
                                            !element.isCompleted &&
                                            !element.isOverdue &&
                                            !element.isDueToday,
                                    }"
                                >
                                    <div class="space-y-2 p-3">
                                        <p
                                            class="cursor-pointer text-sm"
                                            @click="
                                                router.push({
                                                    name: 'TaskShow',
                                                    params: {
                                                        uuid: element.uuid,
                                                    },
                                                })
                                            "
                                        >
                                            {{ element.title }}
                                        </p>
                                        <div
                                            class="flex justify-between text-xs"
                                        >
                                            <div class="space-x-2">
                                                <span
                                                    ><i
                                                        class="far fa-clock"
                                                    ></i>
                                                    {{
                                                        element.due.formatted
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                        <div
                                            class="flex justify-between text-xs"
                                        >
                                            <div class="space-x-2">
                                                <span
                                                    class="cursor-move"
                                                    v-tooltip="
                                                        $trans('general.move')
                                                    "
                                                    ><i
                                                        class="fas fa-arrows-up-down-left-right text-gray-400 dark:text-gray-900"
                                                    ></i
                                                ></span>
                                                <span
                                                    class="text-xs text-gray-400"
                                                    >{{
                                                        element.codeNumber
                                                    }}</span
                                                >
                                            </div>
                                            <div class="space-x-2">
                                                <span
                                                    v-if="element.isOverdue"
                                                    v-tooltip="
                                                        element.overdueDaysDisplay
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-calendar text-warning"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="element.isCompleted"
                                                >
                                                    <i
                                                        class="fas fa-check-circle fa-lg text-success"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="element.isOwner"
                                                    v-tooltip="
                                                        $trans(
                                                            'task.props.owner'
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-crown fa-lg text-primary dark:text-gray-400"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="
                                                        !element.isOwner &&
                                                        element.isMember
                                                    "
                                                    v-tooltip="
                                                        $trans(
                                                            'task.member.member'
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-user fa-lg text-primary dark:text-gray-400"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="element.isArchived"
                                                    v-tooltip="
                                                        $trans(
                                                            'general.archived'
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-box-archive fa-lg text-primary dark:text-gray-400"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="element.isFavorite"
                                                    v-tooltip="
                                                        $trans(
                                                            'task.props.favorite'
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-star fa-lg text-warning"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="
                                                        element.shouldRepeat &&
                                                        element.repeatation
                                                            ?.nextRepeatDate
                                                            .formatted
                                                    "
                                                    v-tooltip="
                                                        $trans(
                                                            'task.repeat.props.next_repeat_date'
                                                        ) +
                                                        ': ' +
                                                        element.repeatation
                                                            ?.nextRepeatDate
                                                            .formatted
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-repeat fa-lg text-info"
                                                    ></i>
                                                </span>
                                                <span
                                                    v-if="element.isCancelled"
                                                    v-tooltip="
                                                        $trans(
                                                            'general.cancelled'
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-ban fa-lg text-danger"
                                                    ></i>
                                                </span>
                                                <i
                                                    v-if="element.priority"
                                                    class="fas fa-circle"
                                                    :style="`color: ${element.priority.color};`"
                                                    v-tooltip="
                                                        element.priority.name
                                                    "
                                                ></i>
                                                <i
                                                    v-if="element.category"
                                                    class="fas fa-square"
                                                    :style="`color: ${element.category.color};`"
                                                    v-tooltip="
                                                        element.category.name
                                                    "
                                                ></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <ProgressBar
                                            v-if="element.hasProgress"
                                            :percent="element.progress"
                                            :color="element.progressColor"
                                            bg-color="transparent"
                                        />
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>
                </div>
            </template>
        </draggable>
    </KanBanView>
</template>

<script>
export default {
    name: "TaskListBoardView",
}
</script>

<script setup>
import { reactive, inject, watch, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import draggable from "vuedraggable"
import { perform } from "@core/helpers/action"
import TaskListForm from "./ListForm.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

const emit = defineEmits(["newListAdded"])

const props = defineProps({
    tasks: {
        type: Object,
        default() {
            return {
                data: [],
            }
        },
    },
    preRequisites: {
        type: Object,
        default: () => ({}),
    },
})

const state = reactive({
    lists: [],
    emptyList: [],
})

const setState = () => {
    state.lists = []

    let columns = [{ name: "Uncategorized", uuid: "uncategorized", items: [] }]

    props.preRequisites.taskLists.forEach((list) => {
        columns.push({ name: list.name, uuid: list.uuid, items: [] })
    })

    props.tasks.data.forEach((task) => {
        if (task.list?.uuid) {
            let list = columns.find((list) => list.name == task.list.name)
            if (list) {
                list.items.push(task)
            } else {
                columns.push({
                    name: task.list.name,
                    uuid: task.list.uuid,
                    items: [task],
                })
            }
        } else {
            columns
                .find((list) => list.name === "Uncategorized")
                .items.push(task)
        }
    })

    if (
        columns.find((list) => list.name === "Uncategorized").items.length === 0
    ) {
        columns = columns.filter((list) => list.name !== "Uncategorized")
    }

    state.lists = columns
}

const listChange = (event) => {
    let uuids = state.lists.map((list) => list.uuid)
    store
        .dispatch("task/reorderList", { uuids: uuids })
        .then((response) => {})
        .catch((error) => {})
}

const itemChange = (event) => {
    let oldIndex = 0
    if (event.removed) {
        oldIndex = event.removed.oldIndex
    }

    if (event.added) {
        let uuid = event.added.element.uuid
        let oldListUuid = event.added.element.list?.uuid
        let listUuid = null
        let itemUuids = []
        state.lists.forEach((list) => {
            if (list.items.find((item) => item.uuid === uuid)) {
                listUuid = list.uuid
                itemUuids = list.items.map((item) => item.uuid)
            }
        })

        store
            .dispatch("task/moveList", {
                uuid: uuid,
                listUuid: listUuid,
                itemUuids: itemUuids,
            })
            .then((response) => {})
            .catch((error) => {
                if (oldListUuid === undefined) {
                    oldListUuid = "uncategorized"
                }
                let oldList = state.lists.find(
                    (list) => list.uuid === oldListUuid
                )
                oldList.items.splice(oldIndex, 0, event.added.element)

                let newList = state.lists.find((list) => list.uuid === listUuid)
                newList.items = newList.items.filter(
                    (item) => item.uuid !== uuid
                )
            })
    }

    if (event.moved) {
        let uuid = event.moved.element.uuid
        let listUuid = event.moved.element.list?.uuid || "uncategorized"
        let list = state.lists.find((list) => list.uuid === listUuid)
        let itemUuids = list.items.map((item) => item.uuid)
        store
            .dispatch("task/reorderItems", { uuids: itemUuids })
            .then((response) => {})
            .catch((error) => {})
    }
}

const newListAdded = (data) => {
    emit("newListAdded", data.option)
    state.lists.push({
        name: data.option.name,
        uuid: data.option.uuid,
        items: [],
    })
}

watch(
    () => props.tasks,
    (value) => {
        setState()
    },
    { deep: true }
)

onMounted(() => {
    setState()
})
</script>
