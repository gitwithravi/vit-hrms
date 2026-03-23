<template>
    <BaseCard no-padding no-content-padding>
        <template #title>
            {{
                $trans("global.recent", {
                    attribute: $trans("leave.request.request"),
                })
            }}
        </template>
        <SimpleTable :header="detailHeader" v-if="records.length > 0">
            <DataRow v-for="record in records" :key="record.uuid">
                <DataCell name="employee">
                    {{ record.employee.name }} ({{
                        record.employee.codeNumber
                    }})
                    <span class="block text-xs"
                        >{{ record.employee.designation }} @
                        {{ record.employee.branch }}</span
                    >
                </DataCell>
                <DataCell name="type">
                    {{ record.leaveType.name }}
                </DataCell>
                <DataCell name="period">
                    {{ record.period }}
                </DataCell>
                <DataCell name="status">
                    <BaseBadge
                        :label="record.status.label"
                        :design="record.status.color"
                    />
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
    name: "DashboardLeaveRequestRecord",
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
    { key: "employee", label: $trans("employee.employee"), visibility: true },
    { key: "type", label: $trans("leave.type.type"), visibility: true },
    {
        key: "period",
        label: $trans("leave.request.props.period"),
        visibility: true,
    },
    {
        key: "status",
        label: $trans("leave.request.props.status"),
        visibility: true,
    },
]
</script>
