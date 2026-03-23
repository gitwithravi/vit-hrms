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
                label: $trans('attendance.type.type'),
                path: 'AttendanceTypeList',
            },
        ]"
    >
        <PageHeaderAction
            name="AttendanceType"
            :title="$trans('attendance.type.type')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'AttendanceType' })"
        >
            <BaseCard v-if="attendanceType.uuid">
                <template #title>
                    {{ attendanceType.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('attendance.type.props.name')">
                        {{ attendanceType.name }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('attendance.type.props.code')">
                        {{ attendanceType.code }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('attendance.type.props.category')"
                    >
                        {{ attendanceType.category.label }}
                        <span v-if="attendanceType.unit.value"
                            >({{ attendanceType.unit.label }})</span
                        >
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('attendance.type.props.alias')"
                    >
                        {{ attendanceType.alias }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('attendance.type.props.description')"
                    >
                        <div v-html="attendanceType.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ attendanceType.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ attendanceType.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            @click="
                                router.push({
                                    name: 'AttendanceTypeEdit',
                                    params: { uuid: attendanceType.uuid },
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
    name: "AttendanceTypeShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialAttendanceType = {}

const initUrl = "attendance/type/"

const attendanceType = reactive({ ...initialAttendanceType })

const setItem = (data) => {
    Object.assign(attendanceType, data)
}
</script>
