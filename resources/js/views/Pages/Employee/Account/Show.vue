<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
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
            name="EmployeeAccount"
            :title="$trans('finance.account.account')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            :module-uuid="route.params.muuid"
            @setItem="setItem"
            @redirectTo="
                router.push({
                    name: 'EmployeeAccount',
                    params: { uuid: employee.uuid },
                })
            "
        >
            <BaseCard v-if="account.uuid">
                <template #title>
                    {{ account.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('finance.account.props.alias')"
                    >
                        {{ account.alias }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.account.props.number')"
                    >
                        {{ account.number }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.account.props.bank_name')"
                    >
                        {{ account.bankName }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.account.props.branch_name')"
                    >
                        {{ account.branchName }}
                    </BaseDataView>

                    <BaseDataView
                        :label="bankCode1Label"
                        v-if="enableBankCode1"
                    >
                        {{ account.bankCode1 }}
                    </BaseDataView>

                    <BaseDataView
                        :label="bankCode2Label"
                        v-if="enableBankCode2"
                    >
                        {{ account.bankCode2 }}
                    </BaseDataView>

                    <BaseDataView
                        :label="bankCode3Label"
                        v-if="enableBankCode3"
                    >
                        {{ account.bankCode3 }}
                    </BaseDataView>

                    <BaseDataView class="col-span-1 sm:col-span-2">
                        <ListMedia
                            :media="account.media"
                            :url="`/app/employees/${employee.uuid}/accounts/${account.uuid}/`"
                        />
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ account.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ account.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('employee:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'EmployeeAccountEdit',
                                    params: {
                                        uuid: employee.uuid,
                                        muuid: account.uuid,
                                    },
                                })
                            "
                        >
                            {{ $trans("general.edit") }}
                        </BaseButton>
                    </ShowButton>
                </template>
            </BaseCard>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeAccountShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { getConfig, perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initialAccount = {}

const initUrl = "employee/account/"
const enableBankCode1 = getConfig("finance.enableBankCode1")
const enableBankCode2 = getConfig("finance.enableBankCode2")
const enableBankCode3 = getConfig("finance.enableBankCode3")
const bankCode1Label = getConfig("finance.bankCode1Label")
const bankCode2Label = getConfig("finance.bankCode2Label")
const bankCode3Label = getConfig("finance.bankCode3Label")

const account = reactive({ ...initialAccount })

const setItem = (data) => {
    Object.assign(account, data)
}
</script>
