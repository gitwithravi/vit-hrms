<template>
    <ParentTransition appear :visibility="true">
        <FilterForm
            @afterFilter="fetchDetail"
            :init-url="initUrl"
            v-if="!route.params.uuid"
        ></FilterForm>
    </ParentTransition>

    <DetailLayoutVertical v-if="isFetched">
        <template #detail>
            <BaseCard
                no-padding
                no-content-padding
                v-if="route.params.uuid && state.codeNumber"
            >
                <template #title>
                    {{ $trans("payroll.props.code_number") }}
                    {{ state.codeNumber }}
                </template>

                <ListContainerVertical>
                    <ListItemView :label="$trans('employee.employee')">
                        {{ state.employee.name }}
                    </ListItemView>

                    <ListItemView
                        :label="$trans('company.department.department')"
                    >
                        {{ state.employee.department }}
                    </ListItemView>

                    <ListItemView
                        :label="$trans('company.designation.designation')"
                    >
                        {{ state.employee.designation }}
                    </ListItemView>

                    <ListItemView :label="$trans('company.branch.branch')">
                        {{ state.employee.branch }}
                    </ListItemView>

                    <ListItemView
                        :label="
                            $trans(
                                'employee.employment_status.employment_status'
                            )
                        "
                    >
                        {{ state.employee.employmentStatus }}
                    </ListItemView>

                    <ListItemView :label="$trans('payroll.props.period')">
                        <span class="font-semibold">{{ state.period }}</span>
                    </ListItemView>
                </ListContainerVertical>
            </BaseCard>

            <BaseCard no-padding no-content-padding>
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
                        v-for="attendance in state.attendanceSummary"
                        :label="attendance.name + ' (' + attendance.code + ')'"
                    >
                        {{ attendance.count }}
                        {{ $trans("list.durations." + attendance.unit) }}
                    </ListItemView>
                </ListContainerVertical>
            </BaseCard>
        </template>

        <div class="space-y-4">
            <BaseCard :is-loading="isLoading" v-if="isFetched">
                <FormAction
                    no-card
                    :init-url="initUrl"
                    :action="route.params.uuid ? 'edit' : 'generate'"
                    :init-form="initForm"
                    :form="form"
                    :set-form="setForm"
                    :after-reset="afterReset"
                    redirect="Payroll"
                    @completed="afterComplete"
                >
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 space-y-4 sm:col-span-1">
                            <div v-for="(record, index) in form.records">
                                <template
                                    v-if="record.payHead.category == 'earning'"
                                >
                                    <BaseLabel class="text-success"
                                        >{{ record.payHead.name }} ({{
                                            record.payHead.code
                                        }})</BaseLabel
                                    >
                                    <BaseInput
                                        currency
                                        v-model="record.amount"
                                        :name="`records.${index}.amount`"
                                        :placeholder="record.payHead.name"
                                        v-model:error="
                                            formErrors[
                                                `records.${index}.amount`
                                            ]
                                        "
                                    />
                                </template>
                            </div>
                        </div>
                        <div class="col-span-2 space-y-4 sm:col-span-1">
                            <div v-for="(record, index) in form.records">
                                <template
                                    v-if="
                                        record.payHead.category == 'deduction'
                                    "
                                >
                                    <BaseLabel class="text-danger"
                                        >{{ record.payHead.name }} ({{
                                            record.payHead.code
                                        }})</BaseLabel
                                    >
                                    <BaseInput
                                        currency
                                        v-model="record.amount"
                                        :name="`records.${index}.amount`"
                                        :placeholder="record.payHead.name"
                                        v-model:error="
                                            formErrors[
                                                `records.${index}.amount`
                                            ]
                                        "
                                    />
                                </template>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div
                                class="text-success flex justify-between text-lg font-semibold"
                            >
                                <span>{{
                                    $trans(
                                        "payroll.salary_structure.props.net_earning"
                                    )
                                }}</span>
                                <span>{{ netEarning }}</span>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div
                                class="text-danger flex justify-between text-lg font-semibold"
                            >
                                <span>{{
                                    $trans(
                                        "payroll.salary_structure.props.net_deduction"
                                    )
                                }}</span>
                                <span>{{ netDeduction }}</span>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div
                                class="text-success flex justify-between text-xl font-semibold"
                            >
                                <span>{{
                                    $trans(
                                        "payroll.salary_structure.props.net_salary"
                                    )
                                }}</span>
                                <span>{{ netSalary }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="col-span-3">
                            <BaseTextarea
                                v-model="form.remarks"
                                name="remarks"
                                :label="$trans('payroll.props.remarks')"
                                v-model:error="formErrors.remarks"
                            />
                        </div>
                    </div>
                </FormAction>
            </BaseCard>
        </div>
    </DetailLayoutVertical>
</template>

<script>
export default {
    name: "PayrollForm",
}
</script>

<script setup>
import { ref, reactive, computed, inject, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"
import { formatAmount, formatCurrency } from "@core/helpers/currency"
import FilterForm from "./FilterGenerate.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

const initForm = {
    records: [],
    remarks: "",
}

const initUrl = "payroll/"

const formErrors = getFormErrors(initUrl)
const netEarning = computed(() => {
    let sum = 0
    let earningRecords = form.records
        .filter((record) => record.payHead.category == "earning")
        .forEach((record) => {
            sum += formatAmount(record.amount)
        })

    return formatCurrency(sum)
})
const netDeduction = computed(() => {
    let sum = 0
    let deductionRecords = form.records
        .filter((record) => record.payHead.category == "deduction")
        .forEach((record) => {
            sum += formatAmount(record.amount)
        })

    return formatCurrency(sum)
})
const netSalary = computed(() => {
    let total = 0
    form.records.forEach((record) => {
        if (record.payHead.category == "earning") {
            total += formatAmount(record.amount)
        } else {
            total -= formatAmount(record.amount)
        }
    })

    return formatCurrency(total)
})

const isLoading = ref(false)
const isFetched = ref(false)
const state = reactive({})
const form = reactive({ ...initForm })

const fetchDetail = async () => {
    isFetched.value = false
    isLoading.value = true
    await store
        .dispatch(initUrl + "fetchDetail", {
            params: route.query,
        })
        .then((response) => {
            Object.assign(state, {
                attendanceSummary: response.attendanceSummary,
                netEarning: response.netEarning.value,
                netDeduction: response.netDeduction.value,
                netSalary: response.netSalary.value,
            })
            Object.assign(form, {
                records: response.records,
            })
            isLoading.value = false
            isFetched.value = true
        })
        .catch((e) => {
            isLoading.value = false
        })
}

const setForm = (data) => {
    Object.assign(state, {
        codeNumber: data.codeNumber,
        employee: data.employee,
        period: data.period,
        attendanceSummary: data.attendanceSummary,
        netEarning: data.netEarning.value,
        netDeduction: data.netDeduction.value,
        netSalary: data.netSalary.value,
    })

    let records = data.records.map((record) => {
        let payHead = {
            uuid: record.payHead.uuid,
            name: record.payHead.name,
            category: record.payHead.category.value,
        }

        return {
            uuid: record.uuid,
            payHead: payHead,
            amount: record.amount.value,
        }
    })

    Object.assign(initForm, {
        records,
        remarks: data.remarks,
    })

    Object.assign(form, cloneDeep(initForm))

    router.push({
        name: route.name,
        query: {
            employee: data.employee?.uuid,
            startDate: data.startDate.value,
            endDate: data.endDate.value,
        },
    })
}

const afterReset = () => {
    isFetched.value = false
}

const afterComplete = () => {
    isFetched.value = false
    emitter.emit("resetFilter")
}

onMounted(async () => {
    if (route.params.uuid) {
        isFetched.value = true
        return
    }

    if (route.query.employee && route.query.startDate && route.query.endDate) {
        await fetchDetail()
    }
})
</script>
