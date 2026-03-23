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
                label: $trans('finance.transaction.transaction'),
                path: 'FinanceTransactionList',
            },
        ]"
    >
        <PageHeaderAction
            name="FinanceTransaction"
            :title="$trans('finance.transaction.transaction')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'FinanceTransaction' })"
        >
            <BaseCard v-if="transaction.uuid">
                <template #title>
                    {{ transaction.codeNumber }} ({{ transaction.type.label }})
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('finance.transaction.props.date')"
                    >
                        {{ transaction.date.formatted }}
                        <TextMuted block v-if="transaction.head">
                            {{ transaction.head }}
                        </TextMuted>
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.transaction.props.amount')"
                    >
                        {{ transaction.amount.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('finance.ledger.ledger')">
                        <div v-for="payment in transaction.payments">
                            <div class="flex">
                                <span class="font-bold">{{
                                    payment.ledger?.name
                                }}</span>
                                <span class="ml-2">{{
                                    payment.amount.formatted
                                }}</span>
                            </div>
                        </div>
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.payment_method.payment_method')"
                    >
                        <PaymentMethodDetail :payments="transaction.payments" />
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('finance.ledger.secondary_ledger')"
                    >
                        <div v-for="record in transaction.records">
                            <div class="flex">
                                <span class="font-bold">{{
                                    record.ledger?.name
                                }}</span>
                                <span class="ml-2">{{
                                    record.amount.formatted
                                }}</span>
                            </div>
                        </div>
                        <span v-if="transaction.transactionable?.name">
                            {{ transaction.transactionable.name }}
                            <TextMuted block>{{
                                transaction.transactionable.contact
                            }}</TextMuted>
                        </span>
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('finance.transaction.props.remarks')"
                    >
                        <div v-html="transaction.remarks"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ transaction.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ transaction.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="
                                perform('transaction:edit') &&
                                transaction.isEditable
                            "
                            design="primary"
                            @click="
                                router.push({
                                    name: 'FinanceTransactionEdit',
                                    params: { uuid: transaction.uuid },
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
    name: "FinanceTransactionShow",
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

const initialTransaction = {}

const initUrl = "finance/transaction/"

const transaction = reactive({ ...initialTransaction })

const setItem = (data) => {
    Object.assign(transaction, data)
}
</script>
