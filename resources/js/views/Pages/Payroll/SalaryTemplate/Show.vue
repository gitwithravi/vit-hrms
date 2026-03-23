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
                label: $trans('payroll.salary_template.salary_template'),
                path: 'PayrollSalaryTemplateList',
            },
        ]"
    >
        <PageHeaderAction
            name="PayrollSalaryTemplate"
            :title="$trans('payroll.salary_template.salary_template')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'PayrollSalaryTemplate' })"
        >
            <DetailLayoutVertical v-if="salaryTemplate.uuid">
                <template #detail>
                    <BaseCard no-padding no-content-padding>
                        <template #title>
                            {{
                                $trans("global.detail", {
                                    attribute: $trans(
                                        "payroll.salary_template.salary_template"
                                    ),
                                })
                            }}
                        </template>
                        <ListContainerVertical>
                            <ListItemView
                                :label="
                                    $trans('payroll.salary_template.props.name')
                                "
                            >
                                {{ salaryTemplate.name }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans(
                                        'payroll.salary_template.props.alias'
                                    )
                                "
                            >
                                {{ salaryTemplate.alias }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.created_at')">
                                {{ salaryTemplate.createdAt.formatted }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.updated_at')">
                                {{ salaryTemplate.updatedAt.formatted }}
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
                                    "payroll.salary_template.salary_template"
                                )
                            }}
                        </template>

                        <SimpleTable
                            :header="detailHeader"
                            v-if="salaryTemplate.records.length > 0"
                        >
                            <DataRow
                                v-for="record in salaryTemplate.records"
                                :key="record.uuid"
                            >
                                <DataCell name="payHead">
                                    <span
                                        :class="{
                                            'text-success':
                                                record.payHead.type ==
                                                'earning',
                                            'text-danger':
                                                record.payHead.type ==
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
                                <DataCell name="attendanceType">
                                    <span v-if="record.attendanceType">{{
                                        record.attendanceType.name
                                    }}</span>
                                    <span v-else-if="record.computation">{{
                                        record.computation
                                    }}</span>
                                    <span v-else>-</span>
                                </DataCell>
                                <DataCell name="action"> </DataCell>
                            </DataRow>
                        </SimpleTable>

                        <dl
                            class="grid grid-cols-1 gap-x-4 gap-y-8 px-4 pt-4 sm:grid-cols-2"
                            v-if="salaryTemplate.description"
                        >
                            <BaseDataView
                                class="col-span-1 sm:col-span-2"
                                :label="
                                    $trans(
                                        'payroll.salary_template.props.description'
                                    )
                                "
                            >
                                <div v-html="salaryTemplate.description"></div>
                            </BaseDataView>
                        </dl>

                        <template #footer>
                            <ShowButton>
                                <BaseButton
                                    v-if="perform('salary-template:edit')"
                                    design="primary"
                                    @click="
                                        router.push({
                                            name: 'PayrollSalaryTemplateEdit',
                                            params: {
                                                uuid: salaryTemplate.uuid,
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
    name: "PayrollSalaryTemplateShow",
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

const initialPayrollSalaryTemplate = {}

const initUrl = "payroll/salaryTemplate/"

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
        key: "type",
        label: $trans("payroll.salary_template.props.type"),
        visibility: true,
    },
    { key: "attendanceType", label: "", visibility: true },
    { key: "action", label: "", visibility: true },
]

const salaryTemplate = reactive({ ...initialPayrollSalaryTemplate })

const setItem = (data) => {
    Object.assign(salaryTemplate, data)
}
</script>
