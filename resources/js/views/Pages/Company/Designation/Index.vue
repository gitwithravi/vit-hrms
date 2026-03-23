<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('company.designation.designation')"
                :navs="[{ label: $trans('company.company'), path: 'Company' }]"
            >
                <PageHeaderAction
                    url="company/designations/"
                    name="CompanyDesignation"
                    :title="$trans('company.designation.designation')"
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
                    path="company/designations/import"
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
                :header="designations.headers"
                :meta="designations.meta"
                module="company.designation"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="designation in designations.data"
                    :key="designation.uuid"
                >
                    <DataCell name="name">
                        {{ designation.name }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ designation.alias }}
                    </DataCell>
                    <DataCell name="parent">
                        {{ designation.parent ? designation.parent.name : "-" }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ designation.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'CompanyDesignationShow',
                                        params: { uuid: designation.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('designation:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'CompanyDesignationEdit',
                                        params: { uuid: designation.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('designation:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'CompanyDesignationDuplicate',
                                        params: { uuid: designation.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('designation:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: designation.uuid,
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
                        v-if="perform('designation:create')"
                        @click="
                            router.push({ name: 'CompanyDesignationCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "company.designation.designation"
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
    name: "CompanyDesignationList",
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
if (perform("designation:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("designation:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

if (perform("designation:create")) {
    dropdownActions.unshift("import")
}

const initUrl = "company/designation/"
const showFilter = ref(false)
const showImport = ref(false)

const designations = reactive({})

const setItems = (data) => {
    Object.assign(designations, data)
}
</script>
