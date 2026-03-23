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
                label: $trans('payroll.pay_head.pay_head'),
                path: 'PayrollPayHeadList',
            },
        ]"
    >
        <PageHeaderAction
            name="PayrollPayHead"
            :title="$trans('payroll.pay_head.pay_head')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'PayrollPayHead' })"
        >
            <BaseCard v-if="payHead.uuid">
                <template #title>
                    {{ payHead.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('payroll.pay_head.props.name')"
                    >
                        {{ payHead.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('payroll.pay_head.props.code')"
                    >
                        {{ payHead.code }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('payroll.pay_head.props.alias')"
                    >
                        {{ payHead.alias }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('payroll.pay_head.props.category')"
                    >
                        {{ payHead.category.label }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('payroll.pay_head.props.description')"
                    >
                        <div v-html="payHead.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ payHead.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ payHead.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            @click="
                                router.push({
                                    name: 'PayrollPayHeadEdit',
                                    params: { uuid: payHead.uuid },
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
    name: "PayrollPayHeadShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialPayHead = {}

const initUrl = "payroll/payHead/"

const payHead = reactive({ ...initialPayHead })

const setItem = (data) => {
    Object.assign(payHead, data)
}
</script>
