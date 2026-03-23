<template>
    <ModuleConfig :navigations="navigations">
        <router-view />
    </ModuleConfig>
</template>

<script>
export default {
    name: "PayrollConfig",
}
</script>

<script setup>
const navigations = [
    {
        name: "PayrollConfigGeneral",
        icon: "fas fa-cogs",
        label: "config.config",
    },
]
</script>
