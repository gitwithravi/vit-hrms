<template>
    <FormAction
        :no-card="true"
        :init-url="initUrl"
        :init-form="initForm"
        action="addList"
        :form="form"
        :keep-adding="false"
        :after-submit="afterSubmit"
    >
        <div class="grid grid-cols-1">
            <div class="col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :placeholder="$trans('task.list.props.name')"
                    v-model:error="formErrors.name"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "TaskListForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { getFormErrors } from "@core/helpers/action"

const emit = defineEmits(["completed"])

const initForm = {
    name: "",
}

const initUrl = "task/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const afterSubmit = (data) => {
    emit("completed", data)
}
</script>
