<template>
    <ModuleConfig :navigations="navigations">
        <router-view />
    </ModuleConfig>
</template>

<script>
export default {
    name: "TaskConfig",
}
</script>

<script setup>
const navigations = [
    {
        name: "TaskConfigGeneral",
        icon: "fas fa-cogs",
        label: "config.config",
    },
    {
        name: "TaskConfigCategory",
        icon: "fas fa-chevron-right",
        label: "task.category.category",
    },
    {
        name: "TaskConfigPriority",
        icon: "fas fa-chevron-right",
        label: "task.priority.priority",
    },
    {
        name: "TaskConfigList",
        icon: "fas fa-chevron-right",
        label: "task.list.list",
    },
]
</script>
