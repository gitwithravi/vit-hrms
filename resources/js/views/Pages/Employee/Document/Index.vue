<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="employee.uuid"
                :title="$trans('employee.document.document')"
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
                    :url="`employees/${employee.uuid}/documents/`"
                    name="EmployeeDocument"
                    :title="$trans('employee.document.document')"
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
                :header="documents.headers"
                :meta="documents.meta"
                module="employee.document"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="document in documents.data"
                    :key="document.uuid"
                >
                    <DataCell name="title">
                        {{ document.title }}
                    </DataCell>
                    <DataCell name="type">
                        {{ document.type.name }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ document.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ document.endDate.formatted }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ document.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeDocumentShow',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: document.uuid,
                                        },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <template v-if="perform('employee:edit')">
                                <FloatingMenuItem
                                    icon="fas fa-edit"
                                    @click="
                                        router.push({
                                            name: 'EmployeeDocumentEdit',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: document.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.edit")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-copy"
                                    @click="
                                        router.push({
                                            name: 'EmployeeDocumentDuplicate',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: document.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.duplicate")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-trash"
                                    @click="
                                        emitter.emit('deleteItem', {
                                            uuid: employee.uuid,
                                            moduleUuid: document.uuid,
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
                        v-if="perform('employee:edit')"
                        @click="router.push({ name: 'EmployeeDocumentCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("employee.document.document"),
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
    name: "EmployeeDocumentList",
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

let userActions = ["filter"]
if (perform("employee:edit")) {
    userActions.unshift("create")
}

const initUrl = "employee/document/"
const showFilter = ref(false)

const documents = reactive({})

const setItems = (data) => {
    Object.assign(documents, data)
}
</script>
