<template>
    <BaseSideover :visibility="visibility" @close="emit('close')">
        <template #title>
            <span>{{
                $trans("global.add", { attribute: $trans("task.media.media") })
            }}</span>
        </template>
        <FormAction
            sideover
            no-card
            no-data-fetch
            cancel-action
            action="create"
            :init-url="initUrl"
            :init-form="initForm"
            :form="form"
            @end="emit('close')"
            @completed="emit('completed')"
            @cancelled="emit('close')"
        >
            <div class="grid grid-cols-1">
                <div class="col">
                    <MediaUpload
                        v-if="task.uuid"
                        :media-token="task.mediaToken"
                        multiple
                        :label="$trans('general.file')"
                        module="task"
                        :media="form.media"
                        @isUpdated="form.mediaUpdated = true"
                        @setHash="(hash) => (form.mediaHash = hash)"
                        @setToken="(token) => (form.mediaToken = token)"
                    />
                </div>
            </div>
        </FormAction>
    </BaseSideover>
</template>

<script>
export default {
    name: "TaskMediaForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const emit = defineEmits(["close", "completed"])

const props = defineProps({
    task: {
        type: Object,
        default() {
            return {}
        },
    },
    visibility: {
        type: Boolean,
        default: false,
    },
})

const initForm = {
    media: [],
    mediaUpdated: false,
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "task/media/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
</script>
