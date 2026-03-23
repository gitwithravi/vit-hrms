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
                label: $trans('finance.payment_method.payment_method'),
                path: 'FinancePaymentMethod',
            },
        ]"
    >
        <PageHeaderAction
            name="FinancePaymentMethod"
            :title="$trans('finance.payment_method.payment_method')"
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
                    name: 'FinancePaymentMethod',
                    params: { uuid: paymentMethod.uuid },
                })
            "
        >
            <BaseCard v-if="paymentMethod.uuid">
                <template #title>
                    {{ paymentMethod.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="
                            $trans('finance.payment_method.props.description')
                        "
                    >
                        <div class="flex flex-wrap gap-2">
                            <BaseBadge
                                size="sm"
                                v-if="paymentMethod.hasInstrumentNumber"
                                >{{
                                    $trans(
                                        "finance.payment_method.props.has_instrument_number"
                                    )
                                }}</BaseBadge
                            >
                            <BaseBadge
                                size="sm"
                                v-if="paymentMethod.hasInstrumentDate"
                                >{{
                                    $trans(
                                        "finance.payment_method.props.has_instrument_date"
                                    )
                                }}</BaseBadge
                            >
                            <BaseBadge
                                size="sm"
                                v-if="paymentMethod.hasClearingDate"
                                >{{
                                    $trans(
                                        "finance.payment_method.props.has_clearing_date"
                                    )
                                }}</BaseBadge
                            >
                            <BaseBadge
                                size="sm"
                                v-if="paymentMethod.hasBankDetail"
                                >{{
                                    $trans(
                                        "finance.payment_method.props.has_bank_detail"
                                    )
                                }}</BaseBadge
                            >
                            <BaseBadge
                                size="sm"
                                v-if="paymentMethod.hasReferenceNumber"
                                >{{
                                    $trans(
                                        "finance.payment_method.props.has_reference_number"
                                    )
                                }}</BaseBadge
                            >
                        </div>
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="
                            $trans('finance.payment_method.props.description')
                        "
                    >
                        {{ paymentMethod.description }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ paymentMethod.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ paymentMethod.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            @click="
                                router.push({
                                    name: 'FinancePaymentMethodEdit',
                                    params: { uuid: paymentMethod.uuid },
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
    name: "FinancePaymentMethodShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialPaymentMethod = {}

const initUrl = "finance/paymentMethod/"

const paymentMethod = reactive({ ...initialPaymentMethod })

const setItem = (data) => {
    Object.assign(paymentMethod, data)
}
</script>
