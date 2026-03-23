<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader :title="$trans('payroll.payroll')">
                <PageHeaderAction
                    url="payrolls/"
                    name="Payroll"
                    :title="$trans('payroll.payroll')"
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
                :header="payrolls.headers"
                :meta="payrolls.meta"
                module="payroll"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="payroll in payrolls.data" :key="payroll.uuid">
                    <DataCell name="codeNumber">
                        {{ payroll.codeNumber }}
                    </DataCell>
                    <DataCell name="employee">
                        {{ payroll.employee.name }} ({{
                            payroll.employee.codeNumber
                        }})
                    </DataCell>
                    <DataCell name="designation">
                        {{ payroll.employee.designation }}
                    </DataCell>
                    <DataCell name="branch">
                        {{ payroll.employee.branch }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ payroll.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ payroll.endDate.formatted }}
                    </DataCell>
                    <DataCell name="total">
                        <span class="text-success font-semibold">{{
                            payroll.total.formatted
                        }}</span>
                    </DataCell>
                    <!-- <DataCell name="paid">
                        {{ payroll.paid.formatted }}
                    </DataCell>
                    <DataCell name="status">
                        <BaseBadge :design="payroll.status.color">{{payroll.status.label}}</BaseBadge>
                    </DataCell> -->
                    <DataCell name="createdAt">
                        {{ payroll.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'PayrollShow',
                                        params: { uuid: payroll.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('payroll:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'PayrollEdit',
                                        params: { uuid: payroll.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('payroll:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: payroll.uuid,
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
                        v-if="perform('payroll:create')"
                        @click="router.push({ name: 'PayrollCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("payroll.payroll"),
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
    name: "PayrollList",
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
if (perform("payroll:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("payroll:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "payroll/"
const showFilter = ref(false)

const payrolls = reactive({})

const setItems = (data) => {
    Object.assign(payrolls, data)
}
</script>
