<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('finance.finance'), path: 'Finance' },
            {
                label: $trans('finance.ledger.ledger'),
                path: 'FinanceLedgerList',
            },
        ]"
    >
        <PageHeaderAction
            name="FinanceLedger"
            :title="$trans('finance.ledger.ledger')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'FinanceLedger' })"
        >
            <BaseCard v-if="ledger.uuid">
                <template #title>
                    {{ ledger.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('finance.ledger.props.alias')">
                        {{ ledger.alias || "-" }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.ledger_type.ledger_type')"
                    >
                        {{ ledger.type?.name || "-" }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.ledger.props.opening_balance')"
                    >
                        {{ ledger.openingBalance.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.ledger.props.net_balance')"
                    >
                        <LedgerBalance highlight :ledger="ledger" />
                    </BaseDataView>

                    <!-- <template v-if="ledger.type.hasCodeNumber">
                        <BaseDataView
                            :label="$trans('finance.ledger.props.code_prefix')"
                        >
                            {{ ledger.codePrefix }} - {{ ledger.codeDigit }} -
                            {{ ledger.codeSuffix }}
                        </BaseDataView>
                    </template> -->

                    <template v-if="ledger.type.hasContact">
                        <BaseDataView
                            :label="$trans('finance.ledger.props.contact')"
                        >
                            {{ ledger.contactNumber }}
                            <TextMuted block v-if="ledger.email">{{
                                ledger.email
                            }}</TextMuted>
                            <TextMuted block v-if="ledger.addressDisplay">{{
                                ledger.addressDisplay
                            }}</TextMuted>
                        </BaseDataView>
                    </template>

                    <template v-if="ledger.type.hasAccount">
                        <BaseDataView
                            :label="$trans('finance.account.props.name')"
                        >
                            {{ ledger.account.name }}
                            <TextMuted block v-if="ledger.account.number">{{
                                ledger.account.number
                            }}</TextMuted>
                            <TextMuted block v-if="ledger.account.bankName">{{
                                ledger.account.bankName
                            }}</TextMuted>
                            <TextMuted block v-if="ledger.account.branchName">{{
                                ledger.account.branchName
                            }}</TextMuted>
                            <TextMuted block v-if="ledger.account.branchCode">{{
                                ledger.account.branchCode
                            }}</TextMuted>
                            <TextMuted
                                block
                                v-if="ledger.account.branchAddress"
                                >{{ ledger.account.branchAddress }}</TextMuted
                            >
                        </BaseDataView>
                    </template>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('finance.ledger.props.description')"
                    >
                        <div v-html="ledger.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ ledger.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ ledger.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="
                                perform('ledger-type:edit') && !ledger.isDefault
                            "
                            design="primary"
                            @click="
                                router.push({
                                    name: 'FinanceLedgerEdit',
                                    params: { uuid: ledger.uuid },
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
    name: "FinanceLedgerShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialLedger = {}

const initUrl = "finance/ledger/"

const ledger = reactive({ ...initialLedger })

const setItem = (data) => {
    Object.assign(ledger, data)
}
</script>
