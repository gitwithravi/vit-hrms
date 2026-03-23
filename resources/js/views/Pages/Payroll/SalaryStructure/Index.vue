<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('payroll.salary_structure.salary_structure')"
                :navs="[{ label: $trans('payroll.payroll'), path: 'Payroll' }]"
            >
                <PageHeaderAction
                    url="payroll/salary-structures/"
                    name="PayrollSalaryStructure"
                    :title="$trans('payroll.salary_structure.salary_structure')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
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
                :header="salaryStructures.headers"
                :meta="salaryStructures.meta"
                module="payroll.salary_structure"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="salaryStructure in salaryStructures.data"
                    :key="salaryStructure.uuid"
                >
                    <DataCell name="employee">
                        {{ salaryStructure.employee.name }} ({{
                            salaryStructure.employee.codeNumber
                        }})
                    </DataCell>
                    <DataCell name="designation">
                        {{ salaryStructure.employee.designation }}
                    </DataCell>
                    <DataCell name="branch">
                        {{ salaryStructure.employee.branch }}
                    </DataCell>
                    <DataCell name="template">
                        {{ salaryStructure.template.name }}
                    </DataCell>
                    <DataCell name="effectiveDate">
                        {{ salaryStructure.effectiveDate.formatted }}
                    </DataCell>
                    <DataCell name="netEarning">
                        <span class="text-success">{{
                            salaryStructure.netEarning.formatted
                        }}</span>
                    </DataCell>
                    <DataCell name="netDeduction">
                        <span class="text-danger">{{
                            salaryStructure.netDeduction.formatted
                        }}</span>
                    </DataCell>
                    <DataCell name="netSalary">
                        <span class="text-success">{{
                            salaryStructure.netSalary.formatted
                        }}</span>
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ salaryStructure.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'PayrollSalaryStructureShow',
                                        params: { uuid: salaryStructure.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('salary-structure:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'PayrollSalaryStructureEdit',
                                        params: { uuid: salaryStructure.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('salary-structure:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'PayrollSalaryStructureDuplicate',
                                        params: { uuid: salaryStructure.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('salary-structure:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: salaryStructure.uuid,
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
                        v-if="perform('salary-structure:create')"
                        @click="
                            router.push({
                                name: 'PayrollSalaryStructureCreate',
                            })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "payroll.salary_structure.salary_structure"
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
    name: "PayrollSalaryStructureList",
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
if (perform("salary-structure:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("salary-structure:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "payroll/salaryStructure/"
const showFilter = ref(false)

const salaryStructures = reactive({})

const setItems = (data) => {
    Object.assign(salaryStructures, data)
}
</script>
