<template>
    <ModuleConfig :navigations="navigations">
        <router-view />
    </ModuleConfig>
</template>

<script>
export default {
    name: "EmployeeConfig",
}
</script>

<script setup>
const navigations = [
    {
        name: "EmployeeConfigGeneral",
        icon: "fas fa-cogs",
        label: "config.config",
    },
    {
        name: "EmployeeConfigEmploymentStatus",
        icon: "fas fa-chevron-right",
        label: "employee.employment_status.employment_status",
    },
    {
        name: "EmployeeConfigEmploymentType",
        icon: "fas fa-chevron-right",
        label: "employee.employment_type.employment_type",
    },
    {
        name: "EmployeeConfigQualificationLevel",
        icon: "fas fa-chevron-right",
        label: "employee.qualification_level.qualification_level",
    },
    {
        name: "EmployeeConfigDocumentType",
        icon: "fas fa-chevron-right",
        label: "employee.document_type.document_type",
    },
]
</script>
