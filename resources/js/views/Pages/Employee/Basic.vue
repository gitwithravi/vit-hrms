<template>
    <PageHeader
        v-if="employee.uuid"
        :title="$trans(route.meta.label)"
        :navs="[
            { label: $trans('employee.employee'), path: 'Employee' },
            {
                label: employee.contact.name,
                path: {
                    name: 'EmployeeShow',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction :additional-actions="additionalActions" />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <BaseCard v-if="employee.uuid">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                <BaseDataView :label="$trans('employee.props.code_number')">
                    {{ employee.codeNumber }}
                </BaseDataView>
                <BaseDataView :label="$trans('employee.props.joining_date')">
                    {{ employee.joiningDate.formatted }}
                </BaseDataView>
                <BaseDataView
                    v-if="employee.leavingDate.value"
                    :label="$trans('employee.props.leaving_date')"
                >
                    {{ employee.leavingDate.formatted }}
                </BaseDataView>
                <BaseDataView :label="$trans('company.department.department')">
                    {{ employee.lastRecord?.department?.name }}
                </BaseDataView>
                <BaseDataView
                    :label="$trans('company.designation.designation')"
                >
                    {{ employee.lastRecord?.designation?.name }}
                </BaseDataView>
                <BaseDataView :label="$trans('company.branch.branch')">
                    {{ employee.lastRecord?.branch?.name }}
                </BaseDataView>
                <BaseDataView :label="$trans('contact.props.birth_date')">
                    {{ employee.contact.birthDate.formatted }}
                </BaseDataView>
                <BaseDataView :label="$trans('contact.props.gender')">
                    {{ employee.contact.gender.label }}
                </BaseDataView>
                <BaseDataView :label="uniqueIdNumber1Label">
                    {{ employee.contact.uniqueIdNumber1 }}
                </BaseDataView>
                <BaseDataView :label="uniqueIdNumber2Label">
                    {{ employee.contact.uniqueIdNumber2 }}
                </BaseDataView>
                <BaseDataView :label="uniqueIdNumber3Label">
                    {{ employee.contact.uniqueIdNumber3 }}
                </BaseDataView>
                <BaseDataView :label="$trans('contact.props.birth_place')">
                    {{ employee.contact.birthPlace }}
                </BaseDataView>
                <BaseDataView :label="$trans('contact.props.nationality')">
                    {{ employee.contact.nationality }}
                </BaseDataView>
                <BaseDataView :label="$trans('contact.props.mother_tongue')">
                    {{ employee.contact.motherTongue }}
                </BaseDataView>
            </dl>
        </BaseCard>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeShowBasic",
}
</script>

<script setup>
import { inject } from "vue"
import { useRoute } from "vue-router"
import { perform, getConfig } from "@core/helpers/action"

const route = useRoute()

const $trans = inject("$trans")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const uniqueIdNumber1Label = getConfig("employee.uniqueIdNumber1Label")
const uniqueIdNumber2Label = getConfig("employee.uniqueIdNumber2Label")
const uniqueIdNumber3Label = getConfig("employee.uniqueIdNumber3Label")

let additionalActions = []
if (perform("employee:edit") && !props.employee.self) {
    additionalActions.push({
        label: $trans("global.edit", {
            attribute: $trans("employee.employee"),
        }),
        path: {
            name: "EmployeeEditBasic",
            params: { uuid: props.employee.uuid },
        },
    })
    additionalActions.push({
        label: $trans("global.edit", {
            attribute: $trans("contact.props.photo"),
        }),
        path: {
            name: "EmployeeEditPhoto",
            params: { uuid: props.employee.uuid },
        },
    })
}
</script>
