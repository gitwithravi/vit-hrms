<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="Task"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3">
                <BaseInput
                    type="text"
                    v-model="form.title"
                    name="title"
                    :label="$trans('task.props.title')"
                    v-model:error="formErrors.title"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    name="category"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('task.category.category'),
                        })
                    "
                    v-model="form.category"
                    v-model:error="formErrors.category"
                    :options="preRequisites.categories"
                    label-prop="name"
                    value-prop="uuid"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelect
                    name="priority"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('task.priority.priority'),
                        })
                    "
                    v-model="form.priority"
                    v-model:error="formErrors.priority"
                    :options="preRequisites.priorities"
                    label-prop="name"
                    value-prop="uuid"
                />
            </div>
        </div>
        <div class="mt-6 grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.startDate"
                    name="startDate"
                    :label="$trans('task.props.start_date')"
                    no-clear
                    v-model:error="formErrors.startDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.dueDate"
                    name="dueDate"
                    :label="$trans('task.props.due_date')"
                    no-clear
                    v-model:error="formErrors.dueDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.dueTime"
                    name="dueTime"
                    :label="$trans('task.props.due_time')"
                    as="time"
                    v-model:error="formErrors.dueTime"
                />
            </div>
            <div class="col-span-3">
                <BaseEditor
                    id="Testing"
                    v-model="form.description"
                    name="description"
                    :edit="route.params.uuid ? true : false"
                    :label="$trans('task.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="task"
                    :media="form.media"
                    @setHash="(hash) => (form.mediaHash = hash)"
                    @setToken="(token) => (form.mediaToken = token)"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "TaskForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    title: "",
    category: "",
    priority: "",
    startDate: "",
    dueDate: "",
    dueTime: "",
    description: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "task/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    categories: [],
    priorities: [],
    lists: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    category: "",
    priority: "",
    isLoaded: route.params.uuid ? false : true,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        startDate: data.startDate.value,
        dueDate: data.dueDate.value,
        dueTime: data.dueTime?.at,
        category: data.category?.uuid,
        priority: data.priority?.uuid,
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.category = data.category?.name
    fetchData.priority = data.priority?.name
    fetchData.isLoaded = true
}
</script>
