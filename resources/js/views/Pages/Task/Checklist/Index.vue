<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <DataTable
            :header="checklists.headers"
            :meta="checklists.meta"
            module="task.checklist"
            @refresh="emitter.emit('listItems')"
        >
            <DataRow v-for="checklist in checklists.data" :key="checklist.uuid">
                <DataCell name="title">
                    {{ checklist.title }}
                </DataCell>
                <DataCell name="status">
                    <i
                        class="fas fa-check-circle text-success"
                        v-if="checklist.isCompleted"
                    ></i>
                </DataCell>
                <DataCell name="due">
                    {{ checklist.due.formatted || "-" }}
                </DataCell>
                <DataCell name="completedAt">
                    {{ checklist.completedAt.formatted || "-" }}
                </DataCell>
                <DataCell name="createdAt">
                    {{ checklist.createdAt.formatted }}
                </DataCell>
                <DataCell name="action">
                    <FloatingMenu
                        v-if="
                            !task.isCompleted &&
                            task.permission?.manageChecklist
                        "
                    >
                        <FloatingMenuItem
                            icon="fas fa-edit"
                            @click="editChecklist(checklist)"
                            >{{ $trans("general.edit") }}</FloatingMenuItem
                        >
                        <FloatingMenuItem
                            icon="fas fa-copy"
                            @click="duplicateChecklist(checklist)"
                            >{{ $trans("general.duplicate") }}</FloatingMenuItem
                        >
                        <FloatingMenuItem
                            :icon="
                                checklist.isCompleted
                                    ? 'fas fa-times text-danger'
                                    : 'fas fa-check text-success'
                            "
                            @click="
                                emitter.emit('actionItem', {
                                    uuid: task.uuid,
                                    moduleUuid: checklist.uuid,
                                    action: 'toggleStatus',
                                    confirmation: true,
                                })
                            "
                            >{{
                                $trans("global.mark", {
                                    attribute: checklist.isCompleted
                                        ? "incomplete"
                                        : "complete",
                                })
                            }}</FloatingMenuItem
                        >
                        <FloatingMenuItem
                            icon="fas fa-trash"
                            @click="
                                emitter.emit('deleteItem', {
                                    uuid: task.uuid,
                                    moduleUuid: checklist.uuid,
                                })
                            "
                            >{{ $trans("general.delete") }}</FloatingMenuItem
                        >
                    </FloatingMenu>
                </DataCell>
            </DataRow>
            <template #actionButton>
                <BaseButton
                    @click="showChecklistForm = true"
                    v-if="!task.isCompleted && task.permission?.manageChecklist"
                >
                    {{
                        $trans("global.add", {
                            attribute: $trans("task.checklist.checklist"),
                        })
                    }}
                </BaseButton>
            </template>
        </DataTable>
    </ListItem>

    <TaskChecklistForm
        :action="formAction"
        :visibility="showChecklistForm"
        :selected-checklist="selectedChecklist"
        @completed="completed"
        @close="closed"
    />
</template>

<script>
export default {
    name: "TaskChecklistList",
}
</script>

<script setup>
import { ref, reactive, inject, onMounted, onBeforeUnmount } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import TaskChecklistForm from "./Form.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const emit = defineEmits(["refresh"])

const props = defineProps({
    task: {
        type: Object,
        default() {
            return {}
        },
    },
})

let userActions = ["filter"]
if (perform("task:edit")) {
    userActions.unshift("create")
}

const initForm = {
    title: "",
    description: "",
    dueDate: "",
}

const initUrl = "task/checklist/"

const formAction = ref("create")
const showChecklistForm = ref(false)
const checklists = reactive({})
const initialChecklist = reactive({
    uuid: null,
    title: "",
    dueDate: "",
    dueTime: "",
    description: "",
})
const selectedChecklist = reactive({})

const setItems = (data) => {
    Object.assign(checklists, data)
}

const editChecklist = (checklist) => {
    Object.assign(selectedChecklist, { ...checklist })
    formAction.value = "update"
    showChecklistForm.value = true
}

const duplicateChecklist = (checklist) => {
    Object.assign(selectedChecklist, { ...checklist })
    formAction.value = "create"
    showChecklistForm.value = true
}

const refreshTask = () => {
    if (props.task.hasProgress) {
        emit("refresh")
    }
}

const completed = () => {
    Object.assign(selectedChecklist, initialChecklist)
    refreshTask()
    emitter.emit("listItems")
}

const closed = () => {
    Object.assign(selectedChecklist, initialChecklist)
    showChecklistForm.value = false
}

onMounted(async () => {
    emitter.on("addTaskChecklist", () => {
        Object.assign(selectedChecklist, initialChecklist)
        formAction.value = "create"
        showChecklistForm.value = true
    })

    emitter.on("actionPerformed", () => {
        refreshTask()
    })
})

onBeforeUnmount(() => {
    emitter.all.delete("addTaskChecklist")
    emitter.all.delete("actionPerformed")
})
</script>
