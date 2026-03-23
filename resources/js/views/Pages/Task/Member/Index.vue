<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
    </ListItem>

    <CardList
        :header="members.headers"
        :meta="members.meta"
        module="task.member"
    >
        <div
            class="grid grid-cols-1 gap-4 px-4 pt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <template v-for="member in members.data" :key="member.uuid">
                <CardView
                    :img-src="member.employee.photo"
                    :path="{
                        name: 'EmployeeShow',
                        params: { uuid: member.employee.uuid },
                    }"
                >
                    <template #title
                        >{{ member.employee.name }}
                        <span class=""
                            >({{ member.employee.codeNumber }})</span
                        ></template
                    >

                    <template #action>
                        <FloatingMenu
                            v-if="
                                !task.isCompleted &&
                                task.permission?.manageMember
                            "
                        >
                            <FloatingMenuItem
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: task.uuid,
                                        moduleUuid: member.uuid,
                                    })
                                "
                                >{{
                                    $trans("general.delete")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </template>

                    <p class="text-xs text-gray-500">
                        {{ member.employee.ageShortDisplay }}
                    </p>
                    <p class="truncate text-sm text-gray-500">
                        {{ member.employee.designation }} @
                        {{ member.employee.branch }}
                    </p>
                    <div class="space-x-2 text-sm text-gray-500">
                        <i
                            class="fas fa-xs fa-user"
                            v-if="member.manageMember"
                            v-tooltip="
                                $trans('task.member.props.manage_member')
                            "
                        ></i>
                        <i
                            class="fas fa-xs fa-list"
                            v-if="member.manageChecklist"
                            v-tooltip="
                                $trans('task.member.props.manage_checklist')
                            "
                        ></i>
                        <i
                            class="fas fa-xs fa-paperclip"
                            v-if="member.manageMedia"
                            v-tooltip="$trans('task.member.props.manage_media')"
                        ></i>
                    </div>
                </CardView>
            </template>
        </div>
        <div>
            <Pagination
                card-view
                :meta="members.meta"
                @refresh="emitter.emit('listItems')"
            ></Pagination>
        </div>
        <template #actionButton>
            <BaseButton
                @click="showMemberForm = true"
                v-if="!task.isCompleted && task.permission?.manageMember"
            >
                {{
                    $trans("global.add", {
                        attribute: $trans("task.member.member"),
                    })
                }}
            </BaseButton>
        </template>
    </CardList>

    <TaskMemberForm
        :visibility="showMemberForm"
        @completed="completed"
        @close="closed"
    />
</template>

<script>
export default {
    name: "TaskMemberList",
}
</script>

<script setup>
import { ref, reactive, inject, onMounted, onBeforeUnmount } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import TaskMemberForm from "./Form.vue"

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
    employees: [],
}

const initUrl = "task/member/"

const showMemberForm = ref(false)
const members = reactive({})

const setItems = (data) => {
    Object.assign(members, data)
}

const completed = () => {
    emitter.emit("listItems")
}

const closed = () => {
    showMemberForm.value = false
}

onMounted(async () => {
    emitter.on("addTaskMember", () => {
        showMemberForm.value = true
    })
})

onBeforeUnmount(() => {
    emitter.all.delete("addTaskMember")
})
</script>
