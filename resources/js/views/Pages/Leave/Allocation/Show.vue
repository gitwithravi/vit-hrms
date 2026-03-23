<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('leave.leave'), path: 'Leave' },
            {
                label: $trans('leave.allocation.allocation'),
                path: 'LeaveAllocationList',
            },
        ]"
    >
        <PageHeaderAction
            name="LeaveAllocation"
            :title="$trans('leave.allocation.allocation')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'LeaveAllocation' })"
        >
            <DetailLayoutVertical v-if="leaveAllocation.uuid">
                <template #detail>
                    <BaseCard no-padding no-content-padding>
                        <template #title>
                            {{
                                $trans("global.detail", {
                                    attribute: $trans(
                                        "leave.allocation.allocation"
                                    ),
                                })
                            }}
                        </template>
                        <ListContainerVertical>
                            <ListItemView
                                :label="$trans('employee.props.name')"
                            >
                                {{ leaveAllocation.employee.name }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('employee.props.code_number')"
                            >
                                {{ leaveAllocation.employee.codeNumber }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('company.department.department')"
                            >
                                {{ leaveAllocation.employee.department }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans('company.designation.designation')
                                "
                            >
                                {{ leaveAllocation.employee.designation }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('company.branch.branch')"
                            >
                                {{ leaveAllocation.employee.branch }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans(
                                        'employee.employment_status.employment_status'
                                    )
                                "
                            >
                                {{ leaveAllocation.employee.employmentStatus }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans('leave.allocation.props.start_date')
                                "
                            >
                                {{ leaveAllocation.startDate.formatted }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans('leave.allocation.props.end_date')
                                "
                            >
                                {{ leaveAllocation.endDate.formatted }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.created_at')">
                                {{ leaveAllocation.createdAt.formatted }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.updated_at')">
                                {{ leaveAllocation.updatedAt.formatted }}
                            </ListItemView>
                        </ListContainerVertical>
                    </BaseCard>
                </template>

                <div class="space-y-4">
                    <BaseCard
                        no-padding
                        no-content-padding
                        bottom-content-padding
                    >
                        <template #title>
                            {{ $trans("leave.type.type") }}
                        </template>

                        <SimpleTable
                            :header="recordHeader"
                            v-if="leaveAllocation.records.length > 0"
                        >
                            <DataRow
                                v-for="record in leaveAllocation.records"
                                :key="record.uuid"
                            >
                                <DataCell name="type">
                                    {{ record.leaveType.name }}
                                </DataCell>
                                <DataCell name="allotted">
                                    {{ record.allotted }}
                                </DataCell>
                                <DataCell name="used">
                                    {{ record.used }}
                                </DataCell>
                                <DataCell name="action"> </DataCell>
                            </DataRow>
                        </SimpleTable>

                        <dl
                            class="grid grid-cols-1 gap-x-4 gap-y-8 px-4 pt-4 sm:grid-cols-2"
                            v-if="leaveAllocation.description"
                        >
                            <BaseDataView
                                class="col-span-1 sm:col-span-2"
                                :label="
                                    $trans('leave.allocation.props.description')
                                "
                            >
                                <div v-html="leaveAllocation.description"></div>
                            </BaseDataView>
                        </dl>

                        <template #footer>
                            <ShowButton>
                                <BaseButton
                                    v-if="perform('leave-allocation:edit')"
                                    design="primary"
                                    @click="
                                        router.push({
                                            name: 'LeaveAllocationEdit',
                                            params: {
                                                uuid: leaveAllocation.uuid,
                                            },
                                        })
                                    "
                                >
                                    {{ $trans("general.edit") }}
                                </BaseButton>
                            </ShowButton>
                        </template>
                    </BaseCard>
                </div>
            </DetailLayoutVertical>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "LeaveAllocationShow",
}
</script>

<script setup>
import { reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const $trans = inject("$trans")

const initialLeaveAllocation = {}

const initUrl = "leave/allocation/"

const recordHeader = [
    { key: "type", label: $trans("leave.type.type"), visibility: true },
    {
        key: "allotted",
        label: $trans("leave.allocation.props.allotted"),
        visibility: true,
    },
    {
        key: "used",
        label: $trans("leave.allocation.props.used"),
        visibility: true,
    },
    { key: "action", label: "", visibility: true },
]

const leaveAllocation = reactive({ ...initialLeaveAllocation })

const setItem = (data) => {
    Object.assign(leaveAllocation, data)
}
</script>
