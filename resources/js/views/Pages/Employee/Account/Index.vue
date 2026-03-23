<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="employee.uuid"
                :title="$trans('finance.account.account')"
                :navs="[
                    { label: $trans('employee.employee'), path: 'Employee' },
                    {
                        label: employee.contact.name,
                        path: {
                            name: 'EmployeeShow',
                            params: { uuid: employee.uuid },
                        },
                    },
                ]"
            >
                <PageHeaderAction
                    :url="`employees/${employee.uuid}/accounts/`"
                    name="EmployeeAccount"
                    :title="$trans('finance.account.account')"
                    :actions="userActions"
                    :dropdown-actions="['print', 'pdf', 'excel']"
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
                :header="accounts.headers"
                :meta="accounts.meta"
                module="employee.account"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="account in accounts.data" :key="account.uuid">
                    <DataCell name="name">
                        {{ account.name }}
                    </DataCell>
                    <DataCell name="alias">
                        {{ account.alias }}
                    </DataCell>
                    <DataCell name="number">
                        {{ account.number }}
                    </DataCell>
                    <DataCell name="bankName">
                        {{ account.bankName }}
                    </DataCell>
                    <DataCell name="branchName">
                        {{ account.branchName }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ account.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeAccountShow',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: account.uuid,
                                        },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <template v-if="perform('employee:edit')">
                                <FloatingMenuItem
                                    icon="fas fa-edit"
                                    @click="
                                        router.push({
                                            name: 'EmployeeAccountEdit',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: account.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.edit")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-copy"
                                    @click="
                                        router.push({
                                            name: 'EmployeeAccountDuplicate',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: account.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.duplicate")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-trash"
                                    @click="
                                        emitter.emit('deleteItem', {
                                            uuid: employee.uuid,
                                            moduleUuid: account.uuid,
                                        })
                                    "
                                    >{{
                                        $trans("general.delete")
                                    }}</FloatingMenuItem
                                >
                            </template>
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        v-if="perform('employee:edit')"
                        @click="router.push({ name: 'EmployeeAccountCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("finance.account.account"),
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
    name: "EmployeeAccountList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

let userActions = ["filter"]
if (perform("employee:edit")) {
    userActions.unshift("create")
}

const initUrl = "employee/account/"
const showFilter = ref(false)

const accounts = reactive({})

const setItems = (data) => {
    Object.assign(accounts, data)
}
</script>
