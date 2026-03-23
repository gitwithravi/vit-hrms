<template>
    <BaseSideover :visibility="visibility" @close="emit('close')">
        <template #title>
            <span v-if="action == 'create'">{{
                $trans("global.add", {
                    attribute: $trans("task.checklist.checklist"),
                })
            }}</span>
            <span v-else>{{
                $trans("global.edit", {
                    attribute: $trans("task.checklist.checklist"),
                })
            }}</span>
        </template>
        <FormAction
            sideover
            no-card
            no-data-fetch
            cancel-action
            :keep-adding="action != 'update' ? true : false"
            :action="action"
            :init-url="initUrl"
            :init-form="initForm"
            :moduleUuid="selectedChecklist?.uuid"
            :form="form"
            @end="emit('close')"
            @completed="emit('completed')"
            @cancelled="emit('close')"
        >
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <BaseInput
                        type="text"
                        v-model="form.title"
                        name="title"
                        :label="$trans('task.checklist.props.title')"
                        v-model:error="formErrors.title"
                        autofocus
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <DatePicker
                        v-model="form.dueDate"
                        name="dueDate"
                        :label="$trans('task.checklist.props.due_date')"
                        v-model:error="formErrors.dueDate"
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <DatePicker
                        v-model="form.dueTime"
                        name="dueTime"
                        :label="$trans('task.checklist.props.due_time')"
                        as="time"
                        v-model:error="formErrors.dueTime"
                    />
                </div>
                <div class="col-span-2">
                    <BaseTextarea
                        v-model="form.description"
                        name="description"
                        :rows="2"
                        :label="$trans('task.checklist.props.description')"
                        v-model:error="formErrors.description"
                    />
                </div>
            </div>
        </FormAction>
    </BaseSideover>
</template>

<script>
export default {
    name: "TaskChecklistForm",
}
</script>

<script setup>
import { reactive, watch } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const emit = defineEmits(["close", "completed"])

const props = defineProps({
    visibility: {
        type: Boolean,
        default: false,
    },
    action: {
        type: String,
        default: "create",
    },
    selectedChecklist: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initForm = {
    title: "",
    dueDate: "",
    dueTime: "",
    description: "",
}

const initUrl = "task/checklist/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

watch(
    () => [props.action, props.selectedChecklist.uuid],
    (value) => {
        if (!props.selectedChecklist.uuid) {
            return
        }

        Object.assign(initForm, {
            ...props.selectedChecklist,
            dueDate: props.selectedChecklist?.dueDate.value,
            dueTime: props.selectedChecklist?.dueTime?.at || "",
        })

        Object.assign(form, cloneDeep(initForm))
    }
)
</script>
