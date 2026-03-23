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
                label: $trans('employee.work_shift.work_shift'),
                path: {
                    name: 'EmployeeWorkShift',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeWorkShift"
            :title="$trans('attendance.work_shift.work_shift')"
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
                    name: 'EmployeeWorkShift',
                    params: { uuid: employee.uuid },
                })
            "
        >
            <BaseCard v-if="workShift.uuid">
                <template #title>
                    {{ workShift.workShift.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('attendance.work_shift.work_shift')"
                        class="col-span-1 sm:col-span-2"
                    >
                        {{ workShift.workShift.name }} ({{
                            workShift.workShift.code
                        }})
                    </BaseDataView>

                    <BaseDataView
                        :label="
                            $trans('attendance.work_shift.props.start_date')
                        "
                    >
                        {{ workShift.startDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('attendance.work_shift.props.end_date')"
                    >
                        {{ workShift.endDate.formatted }}
                    </BaseDataView>

                    <BaseDataView class="col-span-1 sm:col-span-2">
                        {{ workShift.remarks }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ workShift.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ workShift.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('work-shift:assign')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'EmployeeWorkShiftEdit',
                                    params: {
                                        uuid: employee.uuid,
                                        muuid: workShift.uuid,
                                    },
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
    name: "EmployeeWorkShiftShow",
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

const initialWorkShift = {}

const initUrl = "employee/workShift/"

const workShift = reactive({ ...initialWorkShift })

const setItem = (data) => {
    Object.assign(workShift, data)
}
</script>
