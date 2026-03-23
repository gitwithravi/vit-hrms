<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('attendance.attendance'), path: 'Attendance' },
            {
                label: $trans('attendance.work_shift.work_shift'),
                path: 'AttendanceWorkShiftList',
            },
        ]"
    >
        <PageHeaderAction
            name="AttendanceWorkShift"
            :title="$trans('attendance.work_shift.work_shift')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'AttendanceWorkShift' })"
        >
            <DetailLayoutVertical v-if="workShift.uuid">
                <template #detail>
                    <BaseCard no-padding no-content-padding>
                        <template #title>
                            {{
                                $trans("global.detail", {
                                    attribute: $trans(
                                        "attendance.work_shift.work_shift"
                                    ),
                                })
                            }}
                        </template>
                        <ListContainerVertical>
                            <ListItemView
                                :label="
                                    $trans('attendance.work_shift.props.name')
                                "
                            >
                                {{ workShift.name }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans('attendance.work_shift.props.code')
                                "
                            >
                                {{ workShift.code }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.created_at')">
                                {{ workShift.createdAt.formatted }}
                            </ListItemView>

                            <ListItemView :label="$trans('general.updated_at')">
                                {{ workShift.updatedAt.formatted }}
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
                            {{ $trans("attendance.work_shift.work_shift") }}
                        </template>

                        <SimpleTable
                            :header="recordHeader"
                            v-if="workShift.records.length > 0"
                        >
                            <DataRow
                                v-for="record in workShift.records"
                                :key="record.uuid"
                            >
                                <DataCell name="day">
                                    {{ record.label }}
                                </DataCell>
                                <DataCell name="holiday">
                                    {{
                                        record.isHoliday
                                            ? $trans("general.yes")
                                            : $trans("general.no")
                                    }}
                                </DataCell>
                                <DataCell name="overnight">
                                    {{
                                        !record.isHoliday
                                            ? record.isOvernight
                                                ? $trans("general.yes")
                                                : $trans("general.no")
                                            : "-"
                                    }}
                                </DataCell>
                                <DataCell name="startTime">
                                    {{
                                        !record.isHoliday
                                            ? record.startTimeDisplay
                                            : "-"
                                    }}
                                </DataCell>
                                <DataCell name="endtime">
                                    {{
                                        !record.isHoliday
                                            ? record.endTimeDisplay
                                            : "-"
                                    }}
                                </DataCell>
                                <DataCell name="action"> </DataCell>
                            </DataRow>
                        </SimpleTable>

                        <dl
                            class="grid grid-cols-1 gap-x-4 gap-y-8 px-4 pt-4 sm:grid-cols-2"
                            v-if="workShift.description"
                        >
                            <BaseDataView
                                class="col-span-1 sm:col-span-2"
                                :label="
                                    $trans(
                                        'attendance.work_shift.props.description'
                                    )
                                "
                            >
                                <div v-html="workShift.description"></div>
                            </BaseDataView>
                        </dl>

                        <template #footer>
                            <ShowButton>
                                <BaseButton
                                    v-if="perform('work-shift:edit')"
                                    design="primary"
                                    @click="
                                        router.push({
                                            name: 'AttendanceWorkShiftEdit',
                                            params: { uuid: workShift.uuid },
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
    name: "AttendanceWorkShiftShow",
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

const initialWorkShift = {}

const initUrl = "attendance/workShift/"

const recordHeader = [
    { key: "day", label: $trans("list.durations.day"), visibility: true },
    {
        key: "holiday",
        label: $trans("attendance.work_shift.props.is_holiday"),
        visibility: true,
    },
    {
        key: "overnight",
        label: $trans("attendance.work_shift.props.is_overnight"),
        visibility: true,
    },
    {
        key: "start_time",
        label: $trans("attendance.work_shift.props.start_time"),
        visibility: true,
    },
    {
        key: "end_time",
        label: $trans("attendance.work_shift.props.end_time"),
        visibility: true,
    },
    { key: "action", label: "", visibility: true },
]

const workShift = reactive({ ...initialWorkShift })

const setItem = (data) => {
    Object.assign(workShift, data)
}
</script>
