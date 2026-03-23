<template>
    <BaseCard v-if="task.uuid" :is-loading="isLoading">
        <div class="grid grid-cols-1">
            <BaseDataView class="col-span-1">
                <div class="grid grid-cols-4 gap-6">
                    <div
                        v-for="item in task.media"
                        @click="download(item.uuid)"
                        class="col-span-4 sm:col-span-1"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex cursor-pointer">
                                <span class="mr-4"
                                    ><i
                                        class="fas text-4xl"
                                        :class="item.icon"
                                    ></i>
                                </span>
                                <div class="flex flex-col">
                                    <span>{{ item.name }}</span>
                                    <span>{{ item.size }}</span>
                                    <span>{{ item.uuid }}</span>
                                </div>
                            </div>
                            <div>
                                <FloatingMenu
                                    v-if="
                                        !task.isCompleted &&
                                        task.permission?.manageMedia
                                    "
                                >
                                    <FloatingMenuItem
                                        icon="fas fa-trash"
                                        @click="deleteMedia(item)"
                                        >{{
                                            $trans("general.delete")
                                        }}</FloatingMenuItem
                                    >
                                </FloatingMenu>
                            </div>
                        </div>
                    </div>
                </div>
                <BaseAlert
                    v-if="task.media.length === 0"
                    design="info"
                    size="xs"
                    >{{
                        $trans("general.errors.attachment_not_found")
                    }}</BaseAlert
                >
            </BaseDataView>
        </div>
    </BaseCard>

    <TaskMediaForm
        :task="task"
        :visibility="showMediaForm"
        @completed="emit('refresh')"
        @close="closed"
    />
</template>

<script>
export default {
    name: "TaskMediaList",
}
</script>

<script setup>
import { ref, inject, computed, onMounted, onBeforeUnmount } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { confirmDelete } from "@core/helpers/alert"
import TaskMediaForm from "./Form.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

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

const initUrl = "task/media/"

const isLoading = ref(false)
const showMediaForm = ref(false)

const completed = () => {
    emitter.emit("listItems")
}

const closed = () => {
    showMediaForm.value = false
}

const appUrl = computed(() => store.getters["config/config"]("system.url"))

const download = (uuid) => {
    window.open(
        appUrl.value + `/app/tasks/${props.task.uuid}/` + "media/" + uuid
    )
}

const deleteMedia = async (item) => {
    if (!(await confirmDelete())) {
        return
    }

    isLoading.value = true
    await store
        .dispatch(initUrl + "delete", {
            uuid: props.task.uuid,
            moduleUuid: item.uuid,
        })
        .then(() => {
            isLoading.value = false
            emit("refresh")
        })
        .catch((e) => {
            isLoading.value = false
        })
}

onMounted(async () => {
    emitter.on("addTaskMedia", () => {
        showMediaForm.value = true
    })
})

onBeforeUnmount(() => {
    emitter.all.delete("addTaskMedia")
})
</script>
