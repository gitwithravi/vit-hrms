<template>
    <ListItem
        :init-url="initUrl"
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader :title="$trans('task.task')">
                <PageHeaderAction
                    url="tasks/"
                    name="Task"
                    :title="$trans('task.task')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                >
                    <template #after>
                        <BaseButton
                            design="white"
                            v-if="route.query.view != 'list'"
                            v-tooltip="
                                $trans('global._view', {
                                    attribute: $trans('task.config.views.list'),
                                })
                            "
                            @click="router.push({ query: { view: 'list' } })"
                        >
                            <i class="fas fa-list"></i>
                        </BaseButton>
                        <BaseButton
                            design="white"
                            v-if="route.query.view != 'card'"
                            v-tooltip="
                                $trans('global._view', {
                                    attribute: $trans('task.config.views.card'),
                                })
                            "
                            @click="router.push({ query: { view: 'card' } })"
                        >
                            <i class="fas fa-th-large"></i>
                        </BaseButton>
                        <BaseButton
                            design="white"
                            v-if="route.query.view != 'board'"
                            v-tooltip="
                                $trans('global._view', {
                                    attribute: $trans(
                                        'task.config.views.board'
                                    ),
                                })
                            "
                            @click="router.push({ query: { view: 'board' } })"
                        >
                            <i class="fas fa-table-columns"></i>
                        </BaseButton>
                    </template>
                </PageHeaderAction>
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <ParentTransition
            appear
            :visibility="true"
            v-if="route.query.view == 'card'"
        >
            <CardView :tasks="tasks" />
        </ParentTransition>

        <ParentTransition
            appear
            :visibility="true"
            v-if="route.query.view == 'list'"
        >
            <ListView :tasks="tasks" />
        </ParentTransition>

        <ParentTransition
            appear
            :visibility="true"
            v-if="route.query.view == 'board'"
        >
            <BoardView
                v-if="tasks.meta"
                :tasks="tasks"
                :pre-requisites="preRequisites"
                @newListAdded="newListAdded"
            />
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "TaskList",
}
</script>

<script setup>
import { ref, reactive, inject, watch, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getConfig, perform } from "@core/helpers/action"
import CardView from "./CardView.vue"
import ListView from "./ListView.vue"
import BoardView from "./BoardView.vue"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

let userActions = ["filter"]
if (perform("task:create")) {
    userActions.unshift("create")
}
if (perform("task:config")) {
    userActions.unshift("config")
}

let dropdownActions = []
if (perform("task:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const getTaskView = getConfig("task.view")

const initUrl = "task/"
const preRequisites = reactive({
    taskLists: [],
})
const showFilter = ref(false)

const tasks = reactive({})

const setItems = (data) => {
    Object.assign(tasks, data)
}

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const newListAdded = (data) => {
    preRequisites.taskLists.push(data)
}

const updateView = () => {
    if (
        route.name == "TaskList" &&
        (!route.query.view || route.query.view === undefined)
    ) {
        router.push({ query: { view: getTaskView.value } })
    }
}

watch(
    () => route.query.view,
    (value, oldValue) => {
        updateView()

        if (value && oldValue !== undefined) {
            emitter.emit("listItems")
        }
    }
)

onMounted(() => {
    updateView()
})
</script>
