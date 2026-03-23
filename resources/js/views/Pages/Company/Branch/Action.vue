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
        <BranchForm></BranchForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "CompanyBranchAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import BranchForm from "./Form.vue"

const route = useRoute()
</script>
