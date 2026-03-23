<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('attendance.attendance'), path: 'Attendance' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :pre-requisites="{ data: ['datePlaceholders'] }"
            @setPreRequisites="setPreRequisites"
            :init-url="initUrl"
            data-fetch="attendance"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Attendance"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.allowEmployeeClockInOut"
                        name="allowEmployeeClockInOut"
                        :label="
                            $trans(
                                'attendance.config.props.allow_employee_clock_in_out'
                            )
                        "
                        v-model:error="formErrors.allowEmployeeClockInOut"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.allowEmployeeClockInOutViaDevice"
                        name="allowEmployeeClockInOutViaDevice"
                        :label="
                            $trans(
                                'attendance.config.props.allow_employee_clock_in_out_via_device'
                            )
                        "
                        v-model:error="
                            formErrors.allowEmployeeClockInOutViaDevice
                        "
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.lateGracePeriod"
                        name="lateGracePeriod"
                        :label="
                            $trans('attendance.config.props.late_grace_period')
                        "
                        :label-hint="
                            $trans(
                                'attendance.config.props.late_grace_period_tip'
                            )
                        "
                        v-model:error="formErrors.lateGracePeriod"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.earlyLeavingGracePeriod"
                        name="earlyLeavingGracePeriod"
                        :label="
                            $trans(
                                'attendance.config.props.early_leaving_grace_period'
                            )
                        "
                        :label-hint="
                            $trans(
                                'attendance.config.props.early_leaving_grace_period_tip'
                            )
                        "
                        v-model:error="formErrors.earlyLeavingGracePeriod"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.presentGracePeriod"
                        name="presentGracePeriod"
                        :label="
                            $trans(
                                'attendance.config.props.present_grace_period'
                            )
                        "
                        :label-hint="
                            $trans(
                                'attendance.config.props.present_grace_period_tip'
                            )
                        "
                        v-model:error="formErrors.presentGracePeriod"
                    />
                </div>
            </div>
            <BaseFieldset class="mt-4">
                <template #legend>
                    <div class="flex items-center gap-2">
                        <span>{{
                            $trans(
                                "attendance.config.props.enable_geolocation_timesheet"
                            )
                        }}</span>
                        <BaseSwitch
                            v-model="form.enableGeolocationTimesheet"
                            name="enableGeolocationTimesheet"
                            v-model:error="
                                formErrors.enableGeolocationTimesheet
                            "
                        />
                    </div>
                </template>
                <div
                    class="grid grid-cols-3 gap-6"
                    v-if="form.enableGeolocationTimesheet"
                >
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.geolocationLatitude"
                            name="geolocationLatitude"
                            :label="
                                $trans(
                                    'attendance.config.props.geolocation_latitude'
                                )
                            "
                            v-model:error="formErrors.geolocationLatitude"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.geolocationLongitude"
                            name="geolocationLongitude"
                            :label="
                                $trans(
                                    'attendance.config.props.geolocation_longitude'
                                )
                            "
                            v-model:error="formErrors.geolocationLongitude"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.geolocationRadius"
                            name="geolocationRadius"
                            :trailing-text="$trans('list.distances.mtr')"
                            :label="
                                $trans(
                                    'attendance.config.props.geolocation_radius'
                                )
                            "
                            v-model:error="formErrors.geolocationRadius"
                        />
                    </div>
                </div>
            </BaseFieldset>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "AttendanceConfigGeneral",
}
</script>

<script setup>
import { inject, reactive, computed } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const $trans = inject("$trans")

const initUrl = "config/"
const formErrors = getFormErrors(initUrl)
const datePlaceholderInfo = computed(() =>
    $trans("global.placeholder_info", {
        attribute: preRequisites.datePlaceholders,
    })
)

const preRequisites = reactive({
    datePlaceholders: "",
})

const initForm = {
    allowEmployeeClockInOut: false,
    allowEmployeeClockInOutViaDevice: false,
    lateGracePeriod: "",
    earlyLeavingGracePeriod: "",
    presentGracePeriod: "",
    enableGeolocationTimesheet: false,
    geolocationLatitude: "",
    geolocationLongitude: "",
    geolocationRadius: "",
    type: "attendance",
}

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, {
        datePlaceholders: data.datePlaceholders
            .map((item) => item.value)
            .join(", "),
    })
}
</script>
