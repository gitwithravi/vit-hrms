<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('payroll.salary_template.salary_template')"
                :navs="[{ label: $trans('payroll.payroll'), path: 'Payroll' }]"
            >
                <PageHeaderAction
                    url="payroll/salary-templates/"
                    name="PayrollSalaryTemplate"
                    :title="$trans('payroll.salary_template.salary_template')"
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
                :header="salaryTemplates.headers"
                :meta="salaryTemplates.meta"
                module="payroll.salary_template"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="salaryTemplate in salaryTemplates.data"
                    :key="salaryTemplate.uuid"
                >
                    <DataCell name="name">
                        {{ salaryTemplate.name }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ salaryTemplate.alias }}
                    </DataCell>
                    <DataCell name="salaryStructure">
                        {{ salaryTemplate.structuresCount }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ salaryTemplate.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'PayrollSalaryTemplateShow',
                                        params: { uuid: salaryTemplate.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('salary-template:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'PayrollSalaryTemplateEdit',
                                        params: { uuid: salaryTemplate.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('salary-template:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'PayrollSalaryTemplateDuplicate',
                                        params: { uuid: salaryTemplate.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('salary-template:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: salaryTemplate.uuid,
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
                        v-if="perform('salary-template:create')"
                        @click="
                            router.push({ name: 'PayrollSalaryTemplateCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "payroll.salary_template.salary_template"
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
    name: "PayrollSalaryTemplateList",
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
if (perform("salary-template:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("salary-template:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "payroll/salaryTemplate/"
const showFilter = ref(false)

const salaryTemplates = reactive({})

const setItems = (data) => {
    Object.assign(salaryTemplates, data)
}
</script>
