<template>
    <BaseCard no-padding no-content-padding>
        <template #title>
            {{
                $trans("global.recent", {
                    attribute: $trans("payroll.payroll"),
                })
            }}
        </template>
        <SimpleTable :header="detailHeader" v-if="records.length > 0">
            <DataRow v-for="record in records" :key="record.uuid">
                <DataCell name="codeNumber">
                    {{ record.codeNumber }}
                </DataCell>
                <DataCell name="employee">
                    {{ record.employee.name }} ({{
                        record.employee.codeNumber
                    }})
                    <span class="block text-xs"
                        >{{ record.employee.designation }} @
                        {{ record.employee.branch }}</span
                    >
                </DataCell>
                <DataCell name="period">
                    {{ record.period }}
                </DataCell>
                <DataCell name="total">
                    {{ record.total.formatted }}
                </DataCell>
            </DataRow>
        </SimpleTable>

        <div class="p-2" v-if="records.length == 0">
            <BaseAlert size="xs" design="info">{{
                $trans("general.errors.record_not_found")
            }}</BaseAlert>
        </div>
    </BaseCard>
</template>

<script>
export default {
    name: "DashboardPayrollRecord",
}
</script>

<script setup>
import { onMounted, inject } from "vue"
import { useStore } from "vuex"

const $trans = inject("$trans")

const store = useStore()

const props = defineProps({
    records: {
        type: Array,
        default: [],
    },
})

const detailHeader = [
    {
        key: "codeNumber",
        label: $trans("payroll.props.code_number"),
        visibility: true,
    },
    { key: "employee", label: $trans("employee.employee"), visibility: true },
    { key: "period", label: $trans("payroll.props.period"), visibility: true },
    {
        key: "total",
        label: $trans("payroll.salary_structure.props.net_salary"),
        visibility: true,
    },
]
</script>
