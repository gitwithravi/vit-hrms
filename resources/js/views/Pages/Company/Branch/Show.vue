<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('company.company'), path: 'Company' },
            {
                label: $trans('company.branch.branch'),
                path: 'CompanyBranchList',
            },
        ]"
    >
        <PageHeaderAction
            name="CompanyBranch"
            :title="$trans('company.branch.branch')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'CompanyBranch' })"
        >
            <BaseCard v-if="branch.uuid">
                <template #title>
                    {{ branch.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('company.branch.props.name')">
                        {{ branch.name }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('company.branch.props.code')">
                        {{ branch.code }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('company.branch.props.alias')">
                        {{ branch.alias }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('company.branch.props.parent')"
                    >
                        {{ branch.parent ? branch.parent.name : "-" }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('company.branch.props.description')"
                    >
                        <div v-html="branch.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ branch.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ branch.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('branch:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'CompanyBranchEdit',
                                    params: { uuid: branch.uuid },
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
    name: "CompanyBranchShow",
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

const initialBranch = {}

const initUrl = "company/branch/"

const branch = reactive({ ...initialBranch })

const setItem = (data) => {
    Object.assign(branch, data)
}
</script>
