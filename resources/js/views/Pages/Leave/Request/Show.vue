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
                label: $trans('leave.request.request'),
                path: 'LeaveRequestList',
            },
        ]"
    >
        <PageHeaderAction
            name="LeaveRequest"
            :title="$trans('leave.request.request')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'LeaveRequest' })"
            :refresh="refreshItem"
            @refreshed="refreshItem = false"
        >
            <DetailLayoutVertical v-if="leaveRequest.uuid">
                <template #detail>
                    <BaseCard no-padding no-content-padding>
                        <template #title>
                            {{
                                $trans("global.detail", {
                                    attribute: $trans("employee.employee"),
                                })
                            }}
                        </template>
                        <ListContainerVertical>
                            <ListItemView
                                :label="$trans('employee.props.name')"
                            >
                                {{ leaveRequest.employee.name }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('employee.props.code_number')"
                            >
                                {{ leaveRequest.employee.codeNumber }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('company.department.department')"
                            >
                                {{ leaveRequest.employee.department }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans('company.designation.designation')
                                "
                            >
                                {{ leaveRequest.employee.designation }}
                            </ListItemView>

                            <ListItemView
                                :label="$trans('company.branch.branch')"
                            >
                                {{ leaveRequest.employee.branch }}
                            </ListItemView>

                            <ListItemView
                                :label="
                                    $trans(
                                        'employee.employment_status.employment_status'
                                    )
                                "
                            >
                                {{ leaveRequest.employee.employmentStatus }}
                            </ListItemView>
                        </ListContainerVertical>
                    </BaseCard>
                </template>

                <div class="space-y-4">
                    <BaseCard>
                        <template #title>
                            {{ $trans("leave.request.request") }}
                            <BaseBadge
                                :label="leaveRequest.status.label"
                                :design="leaveRequest.status.color"
                            />
                        </template>

                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <BaseDataView :label="$trans('leave.request.props.period')">
                                <div v-html="leaveRequest.period"></div>
                            </BaseDataView>

                            <BaseDataView :label="$trans('leave.request.props.duration')">
                                <div v-html="leaveRequest.duration"></div>
                            </BaseDataView>

                          <BaseDataView :label="$trans('leave.request.is_half_day.label')">
                            <div v-html="leaveRequest.isHalfDay"></div>
                          </BaseDataView>

                          <BaseDataView :label="$trans('leave.request.half_day_shift.label')">
                            <div v-html="leaveRequest.halfDayShift"></div>
                          </BaseDataView>

                            <BaseDataView class="col-span-1 sm:col-span-2" :label="$trans('leave.request.props.reason')">
                                <div v-html="leaveRequest.reason"></div>
                            </BaseDataView>

                            <BaseDataView
                                class="col-span-1 sm:col-span-2"
                                :label="$trans('leave.request.props.alternate_arrangement')"
                            >
                                <div v-html="leaveRequest.alternateArrangement"></div>
                            </BaseDataView>

                            <BaseDataView
                                class="col-span-1 sm:col-span-2"
                                :label="$trans('leave.request.props.comment')"
                            >
                                <div v-html="leaveRequest.comment"></div>
                            </BaseDataView>

                            <BaseDataView :label="$trans('general.created_at')">
                                {{ leaveRequest.createdAt.formatted }}
                            </BaseDataView>

                            <BaseDataView :label="$trans('general.updated_at')">
                                {{ leaveRequest.updatedAt.formatted }}
                            </BaseDataView>

                            <BaseDataView class="col-span-1 sm:col-span-2">
                                <ListMedia
                                    :media="leaveRequest.media"
                                    :url="`/app/leave/requests/${leaveRequest.uuid}/`"
                                />
                            </BaseDataView>
                        </dl>

                        <template #footer>
                            <ShowButton>
                                <BaseButton
                                    v-if="
                                        perform('leave-request:edit') &&
                                        leaveRequest.status == 'requested'
                                    "
                                    design="primary"
                                    @click="
                                        router.push({
                                            name: 'LeaveRequestEdit',
                                            params: { uuid: leaveRequest.uuid },
                                        })
                                    "
                                >
                                    {{ $trans("general.edit") }}
                                </BaseButton>
                            </ShowButton>
                        </template>
                    </BaseCard>
                    <BaseCard v-if="perform('leave-request:action')">
                        <template #title>
                            {{ $trans("leave.request.action") }}
                        </template>

                        <FormAction
                            no-card
                            :keep-adding="false"
                            :init-url="initUrl"
                            :pre-requisites="true"
                            @setPreRequisites="setPreRequisites"
                            :uuid="leaveRequest.uuid"
                            :no-data-fetch="true"
                            action="status"
                            :init-form="initForm"
                            :form="form"
                            :after-submit="afterSubmit"
                        >
                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-span-2 sm:col-span-1">
                                    <BaseSelect
                                        name="status"
                                        :label="
                                            $trans('global.select', {
                                                attribute: $trans(
                                                    'leave.request.props.status'
                                                ),
                                            })
                                        "
                                        v-model="form.status"
                                        :options="preRequisites.statuses"
                                        v-model:error="formErrors.status"
                                    />
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <BaseTextarea
                                        v-model="form.comment"
                                        name="comment"
                                        :label="
                                            $trans(
                                                'leave.request.props.comment'
                                            )
                                        "
                                        v-model:error="formErrors.comment"
                                    />
                                </div>
                            </div>
                        </FormAction>
                    </BaseCard>
                </div>
            </DetailLayoutVertical>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "LeaveRequestShow",
}
</script>

<script setup>
import { reactive, ref } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform, getFormErrors } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialLeaveRequest = {}

const initForm = {
    status: "",
    comment: "",
}

const initUrl = "leave/request/"
const preRequisites = reactive({
    statuses: [],
})
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const refreshItem = ref(false)
const leaveRequest = reactive({ ...initialLeaveRequest })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setItem = (data) => {
    Object.assign(leaveRequest, data)
}

const afterSubmit = () => {
    refreshItem.value = true
}
</script>
