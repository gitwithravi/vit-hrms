<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('payroll.payroll'), path: 'PayrollList' }]"
    >
        <PageHeaderAction
            name="Payroll"
            :title="$trans('payroll.payroll')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'Payroll' })"
            :refresh="refreshItem"
            @refreshed="refreshItem = false"
        >
            <DetailLayoutVertical v-if="payroll.uuid">
                <template #detail>
                    <BaseCard no-padding no-content-padding>
                        <template #title>
                            {{ $trans("payroll.props.code_number") }}
                            {{ payroll.codeNumber }}
                        </template>
                        <ListContainerVertical>
                            <!-- <ListItemView :label="$trans('payroll.props.status')">
                                <BaseBadge :design="payroll.statusDetail.color">{{payroll.statusDisplay}}</BaseBadge>
                            </ListItemView> -->

                            <ListItemView :label="$trans('general.created_at')">
                                {{ payroll.createdAt.formatted }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.updated_at')">
                                {{ payroll.updatedAt.formatted }}
                            </ListItemView>
                        </ListContainerVertical>
                    </BaseCard>

                    <BaseCard class="mt-4" no-padding no-content-padding>
                        <template #title>
                            {{
                                $trans("global.summary", {
                                    attribute: $trans("attendance.attendance"),
                                })
                            }}
                        </template>
                        <ListContainerVertical>
                            <ListItemView
                                align="right"
                                v-for="attendance in payroll.attendanceSummary"
                                :label="
                                    attendance.name +
                                    ' (' +
                                    attendance.code +
                                    ')'
                                "
                            >
                                {{ attendance.count }}
                                {{
                                    $trans("list.durations." + attendance.unit)
                                }}
                            </ListItemView>
                        </ListContainerVertical>
                    </BaseCard>
                </template>

                <BaseCard no-padding no-content-padding bottom-content-padding>
                    <template #title>
                        {{ $trans("payroll.payroll") }}
                    </template>

                    <dl
                        class="grid grid-cols-1 gap-x-4 gap-y-8 px-4 py-2 sm:grid-cols-4"
                    >
                        <BaseDataView :label="$trans('employee.employee')">
                            {{ payroll.employee.name }}
                        </BaseDataView>

                        <BaseDataView
                            :label="$trans('employee.props.code_number')"
                        >
                            {{ payroll.employee.codeNumber }}
                        </BaseDataView>

                        <BaseDataView
                            :label="$trans('employee.props.joining_date')"
                        >
                            {{ payroll.employee.joiningDate.formatted }}
                        </BaseDataView>

                        <BaseDataView
                            :label="$trans('employee.props.joining_date')"
                        >
                            {{ payroll.employee.joiningDate.formatted }}
                        </BaseDataView>

                        <BaseDataView
                            :label="$trans('company.department.department')"
                        >
                            {{ payroll.employee.department }}
                        </BaseDataView>

                        <BaseDataView
                            :label="$trans('company.designation.designation')"
                        >
                            {{ payroll.employee.designation }}
                        </BaseDataView>

                        <BaseDataView :label="$trans('company.branch.branch')">
                            {{ payroll.employee.branch }}
                        </BaseDataView>

                        <BaseDataView
                            :label="
                                $trans(
                                    'employee.employment_status.employment_status'
                                )
                            "
                        >
                            {{ payroll.employee.employmentStatus }}
                        </BaseDataView>

                        <BaseDataView
                            class="col-span-1 sm:col-span-2"
                            :label="$trans('payroll.props.period')"
                        >
                            <span class="font-semibold">{{
                                payroll.period
                            }}</span>
                        </BaseDataView>

                        <BaseDataView
                            class="col-span-1 sm:col-span-2"
                            :label="$trans('payroll.props.duration')"
                        >
                            <span class="font-semibold">{{
                                payroll.duration
                            }}</span>
                        </BaseDataView>
                    </dl>

                    <div
                        class="mt-4 grid grid-cols-2 border-t border-gray-200 dark:border-gray-700"
                    >
                        <div
                            class="col-span-2 border-r border-gray-200 dark:border-gray-700 sm:col-span-1"
                        >
                            <SimpleTable corner="sharp" :header="detailHeader">
                                <DataRow
                                    v-for="record in payroll.records.filter(
                                        (record) =>
                                            record.payHead.category.value ==
                                            'earning'
                                    )"
                                    :key="record.uuid"
                                >
                                    <DataCell name="payHead">
                                        <span class="text-success">
                                            {{ record.payHead.name }}
                                        </span>
                                    </DataCell>
                                    <DataCell name="amount">
                                        <span class="text-success">
                                            {{ record.amount.formatted }}
                                        </span>
                                    </DataCell>
                                </DataRow>
                                <DataRow v-for="n in filler('earning')">
                                    <DataCell name="payHead">&nbsp;</DataCell>
                                    <DataCell name="amount">&nbsp;</DataCell>
                                </DataRow>
                                <DataRow>
                                    <DataCell name="payHead">
                                        <span
                                            class="text-success text-md font-semibold"
                                        >
                                            {{
                                                $trans(
                                                    "payroll.salary_structure.props.net_earning"
                                                )
                                            }}
                                        </span>
                                    </DataCell>
                                    <DataCell name="amount">
                                        <span
                                            class="text-success text-md font-semibold"
                                        >
                                            {{ payroll.netEarning.formatted }}
                                        </span>
                                    </DataCell>
                                </DataRow>
                                <DataRow>
                                    <DataCell name="payHead">
                                        <span
                                            class="text-success text-xl font-semibold"
                                        >
                                            {{
                                                $trans(
                                                    "payroll.salary_structure.props.net_salary"
                                                )
                                            }}
                                        </span>
                                    </DataCell>
                                    <DataCell name="amount">
                                        <span
                                            class="text-success text-xl font-semibold"
                                        >
                                            {{ payroll.total.formatted }}
                                        </span>
                                    </DataCell>
                                </DataRow>
                            </SimpleTable>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <SimpleTable corner="sharp" :header="detailHeader">
                                <DataRow
                                    v-for="record in payroll.records.filter(
                                        (record) =>
                                            record.payHead.category.value ==
                                            'deduction'
                                    )"
                                    :key="record.uuid"
                                >
                                    <DataCell name="payHead">
                                        <span class="text-danger">
                                            {{ record.payHead.name }}
                                        </span>
                                    </DataCell>
                                    <DataCell name="amount">
                                        <span class="text-danger">
                                            {{ record.amount.formatted }}
                                        </span>
                                    </DataCell>
                                </DataRow>
                                <DataRow v-for="n in filler('deduction')">
                                    <DataCell name="payHead">&nbsp;</DataCell>
                                    <DataCell name="amount">&nbsp;</DataCell>
                                </DataRow>
                                <DataRow>
                                    <DataCell name="payHead">
                                        <span
                                            class="text-danger text-md font-semibold"
                                        >
                                            {{
                                                $trans(
                                                    "payroll.salary_structure.props.net_deduction"
                                                )
                                            }}
                                        </span>
                                    </DataCell>
                                    <DataCell name="amount">
                                        <span
                                            class="text-danger text-md font-semibold"
                                        >
                                            {{ payroll.netDeduction.formatted }}
                                        </span>
                                    </DataCell>
                                </DataRow>
                                <DataRow>
                                    <DataCell name="payHead"
                                        ><span
                                            class="text-success text-xl font-semibold"
                                            >&nbsp;</span
                                        ></DataCell
                                    >
                                    <DataCell name="amount">&nbsp;</DataCell>
                                </DataRow>
                            </SimpleTable>
                        </div>
                    </div>

                    <template #footer>
                        <ShowButton>
                            <BaseButton
                                v-if="perform('payroll:edit')"
                                design="primary"
                                @click="
                                    router.push({
                                        name: 'PayrollEdit',
                                        params: { uuid: payroll.uuid },
                                    })
                                "
                            >
                                {{ $trans("general.edit") }}
                            </BaseButton>
                        </ShowButton>
                    </template>
                </BaseCard>
            </DetailLayoutVertical>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "PayrollShow",
}
</script>

<script setup>
import { reactive, ref, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const $trans = inject("$trans")

const initialPayroll = {
    records: [],
}

const initUrl = "payroll/"

const detailHeader = [
    {
        key: "payHead",
        label: $trans("payroll.pay_head.pay_head"),
        visibility: true,
    },
    { key: "amount", label: $trans("payroll.props.amount"), visibility: true },
]

const filler = (type) => {
    let earningCount = payroll.records.filter(
        (record) => record.payHead.category.value == "earning"
    ).length
    let deductionCount = payroll.records.filter(
        (record) => record.payHead.category.value == "deduction"
    ).length

    if (type == "earning" && earningCount < deductionCount) {
        return deductionCount - earningCount
    } else if (type == "deduction" && deductionCount < earningCount) {
        return earningCount - deductionCount
    }

    return 0
}

const refreshItem = ref(false)
const payroll = reactive({ ...initialPayroll })

const setItem = (data) => {
    Object.assign(payroll, data)
}
</script>
