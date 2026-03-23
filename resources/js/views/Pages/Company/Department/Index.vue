<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('company.department.department')"
                :navs="[{ label: $trans('company.company'), path: 'Company' }]"
            >
                <PageHeaderAction
                    url="company/departments/"
                    name="CompanyDepartment"
                    :title="$trans('company.department.department')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                    @toggleImport="showImport = !showImport"
                />
            </PageHeader>
        </template>

        <template #import>
            <ParentTransition appear :visibility="showImport">
                <BaseImport
                    path="company/departments/import"
                    @cancelled="showImport = false"
                    @hide="showImport = false"
                    @completed="emitter.emit('listItems')"
                />
            </ParentTransition>
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
                :header="departments.headers"
                :meta="departments.meta"
                module="company.department"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="department in departments.data"
                    :key="department.uuid"
                >
                    <DataCell name="name">
                        {{ department.name }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ department.alias }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ department.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'CompanyDepartmentShow',
                                        params: { uuid: department.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('department:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'CompanyDepartmentEdit',
                                        params: { uuid: department.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('department:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'CompanyDepartmentDuplicate',
                                        params: { uuid: department.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('department:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: department.uuid,
                                    })
                                "
                                >{{
                                    $trans("general.delete")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        v-if="perform('department:create')"
                        @click="
                            router.push({ name: 'CompanyDepartmentCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "company.department.department"
                                ),
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
    name: "CompanyDepartmentList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["filter"]
if (perform("department:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("department:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

if (perform("department:create")) {
    dropdownActions.unshift("import")
}

const initUrl = "company/department/"
const showFilter = ref(false)
const showImport = ref(false)

const departments = reactive({})

const setItems = (data) => {
    Object.assign(departments, data)
}
</script>
