<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('leave.leave'), path: 'Leave' },
            { label: $trans('leave.type.type'), path: 'LeaveTypeList' },
        ]"
    >
        <PageHeaderAction
            name="LeaveType"
            :title="$trans('leave.type.type')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'LeaveType' })"
        >
            <BaseCard v-if="leaveType.uuid">
                <template #title>
                    {{ leaveType.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('leave.type.props.name')">
                        {{ leaveType.name }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('leave.type.props.code')">
                        {{ leaveType.code }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('leave.type.props.alias')">
                        {{ leaveType.alias }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('leave.type.props.description')"
                    >
                        <div v-html="leaveType.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ leaveType.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ leaveType.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            @click="
                                router.push({
                                    name: 'LeaveTypeEdit',
                                    params: { uuid: leaveType.uuid },
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
    name: "LeaveTypeShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialLeaveType = {}

const initUrl = "leave/type/"

const leaveType = reactive({ ...initialLeaveType })

const setItem = (data) => {
    Object.assign(leaveType, data)
}
</script>
