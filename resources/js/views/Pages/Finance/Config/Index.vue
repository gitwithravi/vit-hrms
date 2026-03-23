<template>
    <ModuleConfig :navigations="navigations">
        <router-view />
    </ModuleConfig>
</template>

<script>
export default {
    name: "FinanceConfig",
}
</script>

<script setup>
const navigations = [
    {
        name: "FinanceConfigGeneral",
        icon: "fas fa-cogs",
        label: "config.config",
    },
]
</script>
