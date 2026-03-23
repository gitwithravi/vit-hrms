<template>
    <BaseCard
        no-padding
        no-content-padding
        bottom-content-padding
        class="mb-4"
        v-if="employee.lastRecord"
    >
        <SimpleTable :header="header">
            <DataRow>
                <DataCell name="period">
                    {{ employee.lastRecord.period }}
                </DataCell>
                <DataCell name="department">
                    {{ employee.lastRecord.department.name }}
                </DataCell>
                <DataCell name="designation">
                    {{ employee.lastRecord.designation.name }}
                </DataCell>
                <DataCell name="branch">
                    {{ employee.lastRecord.branch.name }}
                </DataCell>
                <DataCell name="employmentStatus">
                    {{ employee.lastRecord.employmentStatus.name }}
                </DataCell>
            </DataRow>
        </SimpleTable>
    </BaseCard>

    <FormAction
        no-data-fetch
        :init-url="initUrl"
        :uuid="route.params.uuid"
        :module-uuid="route.params.muuid"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        :after-submit="afterSubmit"
        :redirect="{
            name: 'EmployeeRecord',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6" v-if="route.params.muuid">
            <div class="col-span-3 sm:col-span-1">
                <BaseSwitch
                    v-model="form.end"
                    name="end"
                    :label="$trans('employee.record.props.end')"
                    v-model:error="formErrors.end"
                    vertical
                />
            </div>
            <div class="col-span-3 sm:col-span-1" v-if="form.end">
                <DatePicker
                    v-model="form.endDate"
                    name="endDate"
                    :label="$trans('employee.record.props.end_date')"
                    v-model:error="formErrors.endDate"
                />
            </div>
        </div>

        <div
            class="grid grid-cols-3 gap-6"
            :class="{ 'mt-4': route.params.muuid }"
            v-if="!form.end || route.params.muuid"
        >
            <div class="col-span-3 sm:col-span-1">
                <DatePicker
                    v-model="form.startDate"
                    name="startDate"
                    :label="$trans('employee.record.props.start_date')"
                    v-model:error="formErrors.startDate"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="department"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('company.department.department'),
                        })
                    "
                    v-model="form.department"
                    v-model:error="formErrors.department"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.department"
                    init-search-key="name"
                    search-action="company/department/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="designation"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'company.designation.designation'
                            ),
                        })
                    "
                    v-model="form.designation"
                    v-model:error="formErrors.designation"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.designation"
                    init-search-key="name"
                    search-action="company/designation/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="branch"
                    :label="
                        $trans('global.select', {
                            attribute: $trans('company.branch.branch'),
                        })
                    "
                    v-model="form.branch"
                    v-model:error="formErrors.branch"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.branch"
                    init-search-key="name"
                    search-action="company/branch/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="employmentStatus"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'employee.employment_status.employment_status'
                            ),
                        })
                    "
                    v-model="form.employmentStatus"
                    v-model:error="formErrors.employmentStatus"
                    label-prop="name"
                    value-prop="uuid"
                    :init-search="fetchData.employmentStatus"
                    init-search-key="name"
                    search-action="option/list"
                    :additional-search-query="{ type: 'employment_status' }"
                />
            </div>
        </div>
        <div class="mt-4 grid grid-cols-1">
            <div class="col">
                <BaseTextarea
                    v-model="form.remarks"
                    name="remarks"
                    :label="$trans('employee.record.props.remarks')"
                    v-model:error="formErrors.remarks"
                />
            </div>
        </div>

        <div class="grid grid-cols-1">
            <div class="col">
                <MediaUpload
                    multiple
                    :label="$trans('general.file')"
                    module="employee_record"
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
    name: "EmployeeRecordForm",
}
</script>

<script setup>
import { reactive, inject, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()
const router = useRouter()

const $trans = inject("$trans")
const emitter = inject("emitter")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const header = [
    {
        key: "period",
        label: $trans("employee.record.props.period"),
        visibility: true,
    },
    {
        key: "department",
        label: $trans("company.department.department"),
        visibility: true,
    },
    {
        key: "designation",
        label: $trans("company.designation.designation"),
        visibility: true,
    },
    { key: "branch", label: $trans("company.branch.branch"), visibility: true },
    {
        key: "employmentStatus",
        label: $trans("employee.employment_status.employment_status"),
        visibility: true,
    },
]

const initForm = {
    end: false,
    endDate: "",
    startDate: "",
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
    remarks: "",
    media: [],
    mediaToken: "",
    mediaHash: "",
}

const initUrl = "employee/record/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    department: "",
    designation: "",
    branch: "",
    employmentStatus: "",
    isLoaded: false,
})

const setForm = (data) => {
    Object.assign(initForm, {
        end: data.isEnded ? true : false,
        startDate: data.startDate?.value,
        endDate: data.isEnded ? data.endDate?.value : "",
        department: data.department?.uuid,
        designation: data.designation?.uuid,
        branch: data.branch?.uuid,
        employmentStatus: data.employmentStatus?.uuid,
        remarks: data.remarks,
        media: data.media,
        mediaToken: data.mediaToken,
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.department = data.department?.name
    fetchData.designation = data.designation?.name
    fetchData.branch = data.branch?.name
    fetchData.employmentStatus = data.employmentStatus?.name
    fetchData.isLoaded = true
}

const afterSubmit = () => {
    emitter.emit("employeeUpdated")
    router.push({
        name: "EmployeeRecord",
        params: { uuid: props.employee.uuid },
    })
}

onMounted(() => {
    if (route.params.muuid) {
        return
    }

    Object.assign(initForm, {
        department: props.employee.lastRecord?.department?.uuid,
        designation: props.employee.lastRecord?.designation?.uuid,
        branch: props.employee.lastRecord?.branch?.uuid,
        employmentStatus: props.employee.lastRecord?.employmentStatus?.uuid,
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.department = props.employee.lastRecord?.department?.name
    fetchData.designation = props.employee.lastRecord?.designation?.name
    fetchData.branch = props.employee.lastRecord?.branch?.name
    fetchData.employmentStatus =
        props.employee.lastRecord?.employmentStatus?.name
    fetchData.isLoaded = true
})
</script>
