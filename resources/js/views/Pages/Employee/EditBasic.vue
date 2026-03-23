<template>
    <PageHeader
        v-if="employee.uuid"
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
        ]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <template v-if="employee.uuid">
            <FormAction
                :pre-requisites="true"
                @setPreRequisites="setPreRequisites"
                :init-url="initUrl"
                no-data-fetch
                :init-form="initForm"
                :form="form"
                stay-on
                :after-submit="afterSubmit"
                :redirect="{
                    name: 'EmployeeShowBasic',
                    params: { uuid: employee.uuid },
                }"
            >
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <BaseLabel>{{
                            $trans("employee.props.name")
                        }}</BaseLabel>
                        <div class="flex">
                            <NameInput
                                v-model:firstName="form.firstName"
                                v-model:middleName="form.middleName"
                                v-model:thirdName="form.thirdName"
                                v-model:lastName="form.lastName"
                                v-model:formErrors="formErrors"
                            />
                        </div>
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseLabel>{{
                            $trans("contact.props.gender")
                        }}</BaseLabel>
                        <BaseRadioGroup
                            top-margin
                            :options="preRequisites.genders"
                            name="gender"
                            v-model="form.gender"
                            v-model:error="formErrors.gender"
                            horizontal
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <DatePicker
                            v-model="form.birthDate"
                            name="birthDate"
                            :label="$trans('contact.props.birth_date')"
                            no-clear
                            v-model:error="formErrors.birthDate"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.uniqueIdNumber1"
                            name="uniqueIdNumber1"
                            :label="uniqueIdNumber1Label"
                            v-model:error="formErrors.uniqueIdNumber1"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.uniqueIdNumber2"
                            name="uniqueIdNumber2"
                            :label="uniqueIdNumber2Label"
                            v-model:error="formErrors.uniqueIdNumber2"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.uniqueIdNumber3"
                            name="uniqueIdNumber3"
                            :label="uniqueIdNumber3Label"
                            v-model:error="formErrors.uniqueIdNumber3"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.birthPlace"
                            name="birthPlace"
                            :label="$trans('contact.props.birth_place')"
                            v-model:error="formErrors.birthPlace"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.nationality"
                            name="nationality"
                            :label="$trans('contact.props.nationality')"
                            v-model:error="formErrors.nationality"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.motherTongue"
                            name="motherTongue"
                            :label="$trans('contact.props.mother_tongue')"
                            v-model:error="formErrors.motherTongue"
                        />
                    </div>
                </div>
            </FormAction>
        </template>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeEditBasic",
}
</script>

<script setup>
import { reactive, inject, onMounted } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getConfig, getFormErrors } from "@core/helpers/action"

const route = useRoute()

const emitter = inject("emitter")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initForm = {
    firstName: "",
    middleName: "",
    thirdName: "",
    lastName: "",
    gender: "",
    birthDate: "",
    uniqueIdNumber1: "",
    uniqueIdNumber2: "",
    uniqueIdNumber3: "",
    birthPlace: "",
    nationality: "",
    motherTongue: "",
}

const initUrl = "employee/"
const formErrors = getFormErrors(initUrl)
const uniqueIdNumber1Label = getConfig("employee.uniqueIdNumber1Label")
const uniqueIdNumber2Label = getConfig("employee.uniqueIdNumber2Label")
const uniqueIdNumber3Label = getConfig("employee.uniqueIdNumber3Label")

const preRequisites = reactive({
    genders: [],
})

const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

onMounted(async () => {
    Object.assign(initForm, {
        firstName: props.employee.contact.firstName,
        middleName: props.employee.contact.middleName,
        thirdName: props.employee.contact.thirdName,
        lastName: props.employee.contact.lastName,
        gender: props.employee.contact.gender?.value,
        birthDate: props.employee.contact.birthDate?.value,
        uniqueIdNumber1: props.employee.contact.uniqueIdNumber1,
        uniqueIdNumber2: props.employee.contact.uniqueIdNumber2,
        uniqueIdNumber3: props.employee.contact.uniqueIdNumber3,
        birthPlace: props.employee.contact.birthPlace,
        nationality: props.employee.contact.nationality,
        motherTongue: props.employee.contact.motherTongue,
    })

    Object.assign(form, cloneDeep(initForm))
})

const afterSubmit = () => {
    emitter.emit("employeeUpdated")
}
</script>
