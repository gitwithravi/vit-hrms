<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('employee.employee'), path: 'EmployeeList' },
            {
                label: employee.contact.name,
                path: {
                    name: 'EmployeeShow',
                    params: { uuid: employee.uuid },
                },
            },
            {
                label: $trans('employee.document.document'),
                path: {
                    name: 'EmployeeDocument',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeDocument"
            :title="$trans('employee.document.document')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <DocumentForm></DocumentForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeDocumentAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import DocumentForm from "./Form.vue"

const route = useRoute()

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})
</script>
