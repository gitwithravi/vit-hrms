<template>
    <ListItem
        :init-url="initUrl"
        pre-requisites
        @setPreRequisites="setPreRequisites"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                :title="$trans('employee.mediclaim.dependants')"
                :navs="[{ label: $trans('employee.employee'), path: 'Employee' }]"
            >
                <PageHeaderAction
                    url="mediclaim-dependants/"
                    name="MediclaimDependant"
                    :title="$trans('employee.mediclaim.dependants')"
                    :actions="['filter']"
                    :dropdown-actions="['print', 'pdf', 'excel']"
                    @toggleFilter="showFilter = !showFilter"
                />
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    :pre-requisites="preRequisites"
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                />
            </ParentTransition>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="dependants.headers"
                :meta="dependants.meta"
                module="employee.mediclaim"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="dependant in dependants.data"
                    :key="dependant.uuid"
                >
                    <DataCell name="employeeCode">
                        {{ dependant.employee?.codeNumber }}
                    </DataCell>
                    <DataCell name="employeeName">
                        {{ dependant.employee?.name }}
                    </DataCell>
                    <DataCell name="department">
                        {{ dependant.employee?.department }}
                    </DataCell>
                    <DataCell name="designation">
                        {{ dependant.employee?.designation }}
                    </DataCell>
                    <DataCell name="name">
                        {{ dependant.name }}
                    </DataCell>
                    <DataCell name="relationship">
                        {{ dependant.relationshipLabel }}
                    </DataCell>
                    <DataCell name="topUp">
                        {{ dependant.topUpLabel }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ dependant.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="updatedAt">
                        {{ dependant.updatedAt.formatted }}
                    </DataCell>
                </DataRow>
            </DataTable>
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "MediclaimDependantList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import FilterForm from "./Filter.vue"

const emitter = inject("emitter")

const initUrl = "employee/mediclaimDependant/"
const showFilter = ref(false)

const dependants = reactive({})
const preRequisites = reactive({
    relationships: [],
    topUpOptions: [],
})

const setItems = (data) => {
    Object.assign(dependants, data)
}

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}
</script>
