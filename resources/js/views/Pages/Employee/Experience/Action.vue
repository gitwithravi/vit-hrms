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
                label: $trans('employee.experience.experience'),
                path: {
                    name: 'EmployeeExperience',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeExperience"
            :title="$trans('employee.experience.experience')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ExperienceForm></ExperienceForm>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeExperienceAction",
}
</script>

<script setup>
import { useRoute } from "vue-router"
import ExperienceForm from "./Form.vue"

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
