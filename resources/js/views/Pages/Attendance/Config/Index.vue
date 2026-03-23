<template>
    <ModuleConfig :navigations="navigations">
        <router-view />
    </ModuleConfig>
</template>

<script>
export default {
    name: "AttendanceConfig",
}
</script>

<script setup>
const navigations = [
    {
        name: "AttendanceConfigGeneral",
        icon: "fas fa-cogs",
        label: "config.config",
    },
]
</script>
