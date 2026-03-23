<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="employee.uuid"
                :title="$trans('employee.record.record')"
                :navs="[
                    { label: $trans('employee.employee'), path: 'Employee' },
                    {
                        label: employee.contact.name,
                        path: {
                            name: 'EmployeeShow',
                            params: { uuid: employee.uuid },
                        },
                    },
                ]"
            >
                <PageHeaderAction
                    :url="`employees/${employee.uuid}/records/`"
                    name="EmployeeRecord"
                    :title="$trans('employee.record.record')"
                    :actions="userActions"
                    :dropdown-actions="['print', 'pdf', 'excel']"
                    @toggleFilter="showFilter = !showFilter"
                />
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="records.headers"
                :meta="records.meta"
                module="employee.record"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="record in records.data" :key="record.uuid">
                    <DataCell name="startDate">
                        {{ record.period }}
                        <div class="text-xs">{{ record.duration }}</div>
                    </DataCell>
                    <DataCell name="department">
                        {{ record.department.name }}
                    </DataCell>
                    <DataCell name="designation">
                        {{ record.designation.name }}
                    </DataCell>
                    <DataCell name="branch">
                        {{ record.branch.name }}
                    </DataCell>
                    <DataCell name="employmentStatus">
                        {{ record.employmentStatus.name }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeRecordShow',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: record.uuid,
                                        },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <template
                                v-if="perform('employment-record:manage')"
                            >
                                <FloatingMenuItem
                                    icon="fas fa-edit"
                                    @click="
                                        router.push({
                                            name: 'EmployeeRecordEdit',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: record.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.edit")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-trash"
                                    @click="
                                        emitter.emit('deleteItem', {
                                            uuid: employee.uuid,
                                            moduleUuid: record.uuid,
                                        })
                                    "
                                    >{{
                                        $trans("general.delete")
                                    }}</FloatingMenuItem
                                >
                            </template>
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        v-if="
                            perform('employment-record:manage') &&
                            !employee.lastRecord.endDate
                        "
                        @click="router.push({ name: 'EmployeeRecordCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("employee.record.record"),
                            })
                        }}
                    </BaseButton>
                </template>
            </DataTable>
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "EmployeeRecordList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

let userActions = []
if (
    perform("employment-record:manage") &&
    !props.employee.lastRecord.endDate.value
) {
    userActions.unshift("create")
}

const initUrl = "employee/record/"
const showFilter = ref(false)

const records = reactive({})

const setItems = (data) => {
    Object.assign(records, data)
}
</script>
