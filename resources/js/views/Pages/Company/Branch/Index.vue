<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('company.branch.branch')"
                :navs="[{ label: $trans('company.company'), path: 'Company' }]"
            >
                <PageHeaderAction
                    url="company/branches/"
                    name="CompanyBranch"
                    :title="$trans('company.branch.branch')"
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
                    path="company/branches/import"
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
                :header="branches.headers"
                :meta="branches.meta"
                module="company.branch"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="branch in branches.data" :key="branch.uuid">
                    <DataCell name="name">
                        {{ branch.name }}
                    </DataCell>
                    <DataCell name="code">
                        {{ branch.code }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ branch.alias }}
                    </DataCell>
                    <DataCell name="parent">
                        {{ branch.parent ? branch.parent.name : "-" }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ branch.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'CompanyBranchShow',
                                        params: { uuid: branch.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('branch:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'CompanyBranchEdit',
                                        params: { uuid: branch.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('branch:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'CompanyBranchDuplicate',
                                        params: { uuid: branch.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('branch:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: branch.uuid,
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
                        v-if="perform('branch:create')"
                        @click="router.push({ name: 'CompanyBranchCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("company.branch.branch"),
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
    name: "CompanyBranchList",
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
if (perform("branch:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("branch:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

if (perform("branch:create")) {
    dropdownActions.unshift("import")
}

const initUrl = "company/branch/"
const showFilter = ref(false)
const showImport = ref(false)

const branches = reactive({})

const setItems = (data) => {
    Object.assign(branches, data)
}
</script>
