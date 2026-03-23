<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('employee.employee'), path: 'Employee' },
            {
                label: employee.contact.name,
                path: {
                    name: 'EmployeeShow',
                    params: { uuid: employee.uuid },
                },
            },
            {
                label: $trans('employee.record.record'),
                path: {
                    name: 'EmployeeRecord',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeRecord"
            :title="$trans('employee.record.record')"
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
                    name: 'EmployeeRecord',
                    params: { uuid: employee.uuid },
                })
            "
        >
            <BaseCard v-if="record.uuid">
                <template #title>
                    {{ employee.contact.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('company.department.department')"
                    >
                        {{ record.department.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('company.designation.designation')"
                    >
                        {{ record.designation.name }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('company.branch.branch')">
                        {{ record.branch.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="
                            $trans(
                                'employee.employment_status.employment_status'
                            )
                        "
                    >
                        {{ record.employmentStatus.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.record.props.period')"
                    >
                        {{ record.period }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.record.props.duration')"
                    >
                        {{ record.duration }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('general.attachment')"
                    >
                        <ListMedia
                            :media="record.media"
                            :url="`/app/employees/${employee.uuid}/records/${record.uuid}/`"
                        />
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ record.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ record.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer> </template>
            </BaseCard>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeRecordShow",
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

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initialRecord = {}

const initUrl = "employee/record/"

const record = reactive({ ...initialRecord })

const setItem = (data) => {
    Object.assign(record, data)
}
</script>
