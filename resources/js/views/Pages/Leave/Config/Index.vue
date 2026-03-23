<template>
    <ModuleConfig :navigations="navigations">
        <router-view />
    </ModuleConfig>
</template>

<script>
export default {
    name: "LeaveConfig",
}
</script>

<script setup>
const navigations = [
    {
        name: "LeaveConfigGeneral",
        icon: "fas fa-cogs",
        label: "config.config",
    },
]
</script>
