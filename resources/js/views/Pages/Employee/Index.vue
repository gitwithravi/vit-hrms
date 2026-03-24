<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader :title="$trans('employee.employee')" :navs="[]">
                <PageHeaderAction
                    url="employees/"
                    name="Employee"
                    :title="$trans('employee.employee')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
                    @toggleFilter="showFilter = !showFilter"
                    @toggleImport="showImport = !showImport"
                    @refresh="emitter.emit('listItems')"
                />
            </PageHeader>
        </template>

        <template #import>
            <ParentTransition appear :visibility="showImport">
                <BaseImport
                    path="employees/import"
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

        <ParentTransition
            appear
            :visibility="true"
            v-if="route.query.view != 'list'"
        >
            <CardList
                :header="employees.headers"
                :meta="employees.meta"
                module="employee"
            >
                <div
                    class="grid grid-cols-1 gap-4 px-4 pt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
                >
                    <template
                        v-for="employee in employees.data"
                        :key="employee.uuid"
                    >
                        <CardView
                            :img-src="employee.photo"
                            :path="isDfa ? {} : {
                                name: 'EmployeeShow',
                                params: { uuid: employee.uuid },
                            }"
                        >
                            <template #title
                                >{{ employee.name }}
                                <span class=""
                                    >({{ employee.codeNumber }})</span
                                ></template
                            >
                            <p class="text-xs text-gray-500">
                                {{ employee.age?.short }}
                            </p>
                            <p class="truncate text-sm text-gray-500">
                                {{ employee.designation }} @
                                {{ employee.branch }}
                            </p>
                            <p v-if="isDfa && employee.category" class="text-sm text-gray-500">
                                {{ employee.category }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ employee.period }}
                            </p>
                        </CardView>
                    </template>
                </div>
                <div>
                    <Pagination
                        card-view
                        :meta="employees.meta"
                        @refresh="emitter.emit('listItems')"
                    ></Pagination>
                </div>
                <template #actionButton>
                    <BaseButton
                        v-if="perform('employee:create')"
                        @click="router.push({ name: 'EmployeeCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("employee.employee"),
                            })
                        }}
                    </BaseButton>
                </template>
            </CardList>
        </ParentTransition>

        <ParentTransition
            appear
            :visibility="true"
            v-if="route.query.view == 'list'"
        >
            <DataTable
                :header="employees.headers"
                :meta="employees.meta"
                module="employee"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="employee in employees.data"
                    :key="employee.uuid"
                >
                    <DataCell name="codeNumber">
                        {{ employee.codeNumber }}
                    </DataCell>
                    <DataCell name="name">
                        {{ employee.name }}
                    </DataCell>
                    <DataCell name="joiningDate">
                        {{ employee.joiningDate.formatted }}
                    </DataCell>
                    <DataCell name="employmentStatus">
                        {{ employee.employmentStatus }}
                    </DataCell>
                    <DataCell name="department">
                        {{ employee.department }}
                    </DataCell>
                    <DataCell name="designation">
                        {{ employee.designation }}
                    </DataCell>
                    <DataCell name="branch">
                        {{ employee.branch }}
                    </DataCell>
                    <DataCell name="category">
                        {{ employee.category }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ employee.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action" v-if="!isDfa">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeShow',
                                        params: { uuid: employee.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="
                                    perform('employee:delete') &&
                                    !employee.self &&
                                    !employee.isDefault
                                "
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: employee.uuid,
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
                        v-if="perform('employee:create')"
                        @click="router.push({ name: 'EmployeeCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("employee.employee"),
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
    name: "EmployeeList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform, actingAs } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const isDfa = actingAs("d-f-a")

let userActions = ["filter", "view"]
if (perform("employee:create")) {
    userActions.unshift("create")
}
if (perform("employee:config")) {
    userActions.unshift("config")
}

let dropdownActions = []
if (perform("employee:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

if (perform("employee:create")) {
    dropdownActions.unshift("import")
}

const initUrl = "employee/"
const showFilter = ref(false)
const showImport = ref(false)

const employees = reactive({})

const setItems = (data) => {
    Object.assign(employees, data)
}
</script>
