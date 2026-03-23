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
                label: $trans('finance.ledger_type.ledger_type'),
                path: 'FinanceLedgerTypeList',
            },
        ]"
    >
        <PageHeaderAction
            name="FinanceLedgerType"
            :title="$trans('finance.ledger_type.ledger_type')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'FinanceLedgerType' })"
        >
            <BaseCard v-if="ledgerType.uuid">
                <template #title>
                    {{ ledgerType.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('finance.ledger_type.props.alias')"
                    >
                        {{ ledgerType.alias || "-" }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('finance.ledger_type.props.parent')"
                    >
                        {{ ledgerType.parent?.name || "-" }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('finance.ledger_type.props.description')"
                    >
                        <div v-html="ledgerType.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ ledgerType.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ ledgerType.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="
                                perform('ledger-type:edit') &&
                                !ledgerType.isDefault
                            "
                            design="primary"
                            @click="
                                router.push({
                                    name: 'FinanceLedgerTypeEdit',
                                    params: { uuid: ledgerType.uuid },
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
    name: "FinanceLedgerTypeShow",
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

const initialLedgerType = {}

const initUrl = "finance/ledgerType/"

const ledgerType = reactive({ ...initialLedgerType })

const setItem = (data) => {
    Object.assign(ledgerType, data)
}
</script>
