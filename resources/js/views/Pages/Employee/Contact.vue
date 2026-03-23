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
                <BaseDataView :label="$trans('contact.props.contact_number')">
                    {{ employee.contact.contactNumber }}
                </BaseDataView>
                <BaseDataView
                    :label="
                        $trans('global.alternate', {
                            attribute: $trans('contact.props.contact_number'),
                        })
                    "
                >
                    {{ employee.contact.alternateRecords?.contactNumber }}
                </BaseDataView>
                <BaseDataView />
                <BaseDataView :label="$trans('contact.props.email')">
                    {{ employee.contact.email }}
                </BaseDataView>
                <BaseDataView
                    :label="
                        $trans('global.alternate', {
                            attribute: $trans('contact.props.email'),
                        })
                    "
                >
                    {{ employee.contact.alternateRecords?.email }}
                </BaseDataView>
                <BaseDataView />
                <BaseDataView
                    class="col-span-1 sm:col-span-3"
                    :label="$trans('contact.props.present_address')"
                >
                    {{ employee.contact.presentAddressDisplay }}
                </BaseDataView>
                <BaseDataView
                    class="col-span-1 sm:col-span-3"
                    :label="$trans('contact.props.permanent_address')"
                >
                    {{
                        employee.contact.sameAsPresentAddress
                            ? employee.contact.presentAddressDisplay
                            : employee.contact.permanentAddressDisplay
                    }}
                </BaseDataView>
            </dl>
        </BaseCard>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeShowContact",
}
</script>

<script setup>
import { inject } from "vue"
import { useRoute } from "vue-router"
import { perform } from "@core/helpers/action"

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

let additionalActions = []
if (perform("employee:edit") && !props.employee.self) {
    additionalActions.push({
        label: $trans("global.edit", { attribute: $trans("contact.contact") }),
        path: {
            name: "EmployeeEditContact",
            params: { uuid: props.employee.uuid },
        },
    })
}
</script>
