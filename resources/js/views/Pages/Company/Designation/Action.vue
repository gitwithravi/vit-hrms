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
                label: $trans('company.designation.designation'),
                path: 'CompanyDesignationList',
            },
        ]"
    >
        <PageHeaderAction
            name="CompanyDesignation"
            :title="$trans('company.designation.designation')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <DesignationForm></DesignationForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "CompanyDesignationAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import DesignationForm from "./Form.vue"

const route = useRoute()
</script>
