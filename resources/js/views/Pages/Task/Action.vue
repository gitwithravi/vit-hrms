<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('task.task'), path: 'Task' }]"
    >
        <PageHeaderAction
            name="Task"
            :title="$trans('task.task')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <TaskForm></TaskForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "TaskAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import TaskForm from "./Form.vue"

const route = useRoute()
</script>
