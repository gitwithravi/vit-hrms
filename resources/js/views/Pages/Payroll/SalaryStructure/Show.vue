<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('payroll.payroll'), path: 'Payroll' },
            {
                label: $trans('payroll.salary_structure.salary_structure'),
                path: 'PayrollSalaryStructureList',
            },
        ]"
    >
        <PageHeaderAction
            name="PayrollSalaryStructure"
            :title="$trans('payroll.salary_structure.salary_structure')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'PayrollSalaryStructure' })"
        >
            <DetailLayoutVertical v-if="salaryStructure.uuid">
                <template #detail>
                    <BaseCard no-padding no-content-padding>
                        <template #title>
                            {{
                                $trans("global.detail", {
                                    attribute: $trans(
                                        "payroll.salary_structure.salary_structure"
                                    ),
                                })
                            }}
                        </template>
                        <ListContainerVertical>
                            <ListItemView :label="$trans('employee.employee')">
                                {{ salaryStructure.employee.name }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('employee.props.code_number')"
                            >
                                {{ salaryStructure.employee.codeNumber }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('company.department.department')"
                            >
                                {{ salaryStructure.employee.department }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans('company.designation.designation')
                                "
                            >
                                {{ salaryStructure.employee.designation }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('company.branch.branch')"
                            >
                                {{ salaryStructure.employee.branch }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans(
                                        'employee.employment_status.employment_status'
                                    )
                                "
                            >
                                {{ salaryStructure.employee.employmentStatus }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.created_at')">
                                {{ salaryStructure.createdAt.formatted }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.updated_at')">
                                {{ salaryStructure.updatedAt.formatted }}
                            </ListItemView>
                        </ListContainerVertical>
                    </BaseCard>
                </template>

                <div class="space-y-4">
                    <BaseCard
                        no-padding
                        no-content-padding
                        bottom-content-padding
                    >
                        <template #title>
                            {{
                                $trans(
                                    "payroll.salary_structure.salary_structure"
                                )
                            }}
                        </template>

                        <SimpleTable
                            :header="detailHeader"
                            v-if="salaryStructure.records.length > 0"
                        >
                            <DataRow
                                v-for="record in salaryStructure.records"
                                :key="record.uuid"
                            >
                                <DataCell name="payHead">
                                    <span
                                        :class="{
                                            'text-success':
                                                record.payHead.category.value ==
                                                'earning',
                                            'text-danger':
                                                record.payHead.category.value ==
                                                'deduction',
                                        }"
                                    >
                                        {{ record.payHead.name }}
                                    </span>
                                </DataCell>
                                <DataCell name="payHeadCode">
                                    <span
                                        :class="{
                                            'text-success':
                                                record.payHead.category.value ==
                                                'earning',
                                            'text-danger':
                                                record.payHead.category.value ==
                                                'deduction',
                                        }"
                                    >
                                        {{ record.payHead.code }}
                                    </span>
                                </DataCell>
                                <DataCell name="type">
                                    {{ record.type.label }}
                                </DataCell>
                                <DataCell name="computation">
                                    {{ record.computation || "-" }}
                                </DataCell>
                                <DataCell name="earning">
                                    <span class="text-success font-semibold">{{
                                        record.payHead.category == "earning"
                                            ? record.amount.formatted
                                            : ""
                                    }}</span>
                                </DataCell>
                                <DataCell name="deduction">
                                    <span class="text-danger font-semibold">{{
                                        record.payHead.category == "deduction"
                                            ? record.amount.formatted
                                            : ""
                                    }}</span>
                                </DataCell>
                            </DataRow>
                            <DataRow>
                                <DataCell :colspan="4" name="payHead">
                                </DataCell>
                                <DataCell name="earning">
                                    <span
                                        class="text-success text-lg font-semibold"
                                        >{{
                                            salaryStructure.netEarning.formatted
                                        }}</span
                                    >
                                </DataCell>
                                <DataCell name="deduction">
                                    <span
                                        class="text-danger text-lg font-semibold"
                                        >{{
                                            salaryStructure.netDeduction
                                                .formatted
                                        }}</span
                                    >
                                </DataCell>
                            </DataRow>
                            <DataRow>
                                <DataCell :colspan="4" name="payHead">
                                    <span class="text-xl font-semibold">{{
                                        $trans(
                                            "payroll.salary_structure.props.net_salary"
                                        )
                                    }}</span>
                                </DataCell>
                                <DataCell :colspan="2" name="earning">
                                    <span
                                        class="text-success text-xl font-semibold"
                                        >{{
                                            salaryStructure.netSalary.formatted
                                        }}</span
                                    >
                                </DataCell>
                            </DataRow>
                        </SimpleTable>

                        <dl
                            class="grid grid-cols-1 gap-x-4 gap-y-8 px-4 pt-4 sm:grid-cols-2"
                            v-if="salaryStructure.description"
                        >
                            <BaseDataView
                                class="col-span-1 sm:col-span-2"
                                :label="
                                    $trans(
                                        'payroll.salary_structure.props.description'
                                    )
                                "
                            >
                                <div v-html="salaryStructure.description"></div>
                            </BaseDataView>
                        </dl>

                        <template #footer>
                            <ShowButton>
                                <BaseButton
                                    v-if="perform('salary-structure:edit')"
                                    design="primary"
                                    @click="
                                        router.push({
                                            name: 'PayrollSalaryStructureEdit',
                                            params: {
                                                uuid: salaryStructure.uuid,
                                            },
                                        })
                                    "
                                >
                                    {{ $trans("general.edit") }}
                                </BaseButton>
                            </ShowButton>
                        </template>
                    </BaseCard>
                </div>
            </DetailLayoutVertical>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollSalaryStructureShow",
}
</script>

<script setup>
import { reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const $trans = inject("$trans")

const initialPayrollSalaryStructure = {}

const initUrl = "payroll/salaryStructure/"

const detailHeader = [
    {
        key: "payHead",
        label: $trans("payroll.pay_head.pay_head"),
        visibility: true,
    },
    {
        key: "payHeadCode",
        label: $trans("payroll.pay_head.props.code"),
        visibility: true,
    },
    {
        key: "category",
        label: $trans("payroll.salary_template.props.category"),
        visibility: true,
    },
    {
        key: "computation",
        label: $trans("payroll.salary_template.props.computation"),
        visibility: true,
    },
    {
        key: "earning",
        label: $trans("payroll.pay_head.categories.earning"),
        visibility: true,
    },
    {
        key: "deduction",
        label: $trans("payroll.pay_head.categories.deduction"),
        visibility: true,
    },
]

const salaryStructure = reactive({ ...initialPayrollSalaryStructure })

const setItem = (data) => {
    Object.assign(salaryStructure, data)
}
</script>
