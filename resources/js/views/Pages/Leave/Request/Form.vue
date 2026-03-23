<template>
    <FormAction
        :pre-requisites="true"
        @setPreRequisites="setPreRequisites"
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="LeaveRequest"
    >
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 sm:col-span-1">
                <BaseSelect
                    v-model="form.leaveType"
                    name="leaveType"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('leave.type.type'),
                        })
                    "
                    :options="preRequisites.types"
                    label-prop="name"
                    value-prop="uuid"
                    v-model:error="formErrors.leaveType"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <DatePicker
                    v-model:start="form.startDate"
                    v-model:end="form.endDate"
                    name="dateBetween"
                    as="range"
                    :label="$trans('general.date_between')"
                />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2 sm:col-span-1">
                      <label class="text-sm font-medium">{{$trans('leave.request.is_half_day.label')}}</label>
                      <BaseRadioGroup
                          :horizontal="true"
                          :options="preRequisites.halfDayOptions"
                          v-model="form.isHalfDay"
                          name="is_half_day"
                          v-model:error="formErrors.isHalfDay"
                      />
                    </div>
                    <div class="col-span-2 sm:col-span-1" v-if="form.isHalfDay==='1'">
                      <label class="text-sm font-medium">{{$trans('leave.request.half_day_shift.label')}}</label>
                      <BaseRadioGroup
                          :horizontal="true"
                          :options="preRequisites.halfDayShifts"
                          v-model="form.halfDayShift"
                          name="half_day_shift"
                          v-model:error="formErrors.halfDayShift"
                      />
                    </div>
                </div>
            </div>
            <div class="col-span-2">
                <BaseTextarea
                    v-model="form.reason"
                    name="reason"
                    :label="$trans('leave.request.props.reason')"
                    v-model:error="formErrors.reason"
                />
            </div>
          <div class="col-span-2">
                <BaseTextarea
                    v-model="form.alternateArrangement"
                    name="alternate_arrangement"
                    :label="$trans('leave.request.props.alternate_arrangement')"
                    v-model:error="formErrors.alternateArrangement"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="leave_request"
                    :media="form.media"
                    @setHash="(hash) => (form.mediaHash = hash)"
                    @setToken="(token) => (form.mediaToken = token)"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "LeaveRequestForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import {cloneDeep} from "../../../../core/utils";
import {getFormErrors} from "../../../../core/helpers/action";
import BaseRadioGroup from "../../../../core/components/Forms/BaseRadioGroup.vue";

const route = useRoute()

const initForm = {
    leaveType: "",
    startDate: "",
    endDate: "",
    reason: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
    alternateArrangement: "",
    isHalfDay: "",
    halfDayShift: "",
}

const initUrl = "leave/request/"
const formErrors = getFormErrors(initUrl)
const preRequisites = reactive({
    types: [],
})

const form = reactive({ ...initForm })
const fetchData = reactive({
    leaveType: "",
    isLoaded: !route.params.uuid,
})

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const setForm = (data) => {
    Object.assign(initForm, {
        ...data,
        leaveType: data.leaveType?.uuid,
    })

    Object.assign(form, cloneDeep(initForm))

    fetchData.leaveType = data.leaveType?.uuid
    fetchData.isLoaded = true
}
</script>
