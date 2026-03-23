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
                :init-url="initUrl"
                no-data-fetch
                :init-form="initForm"
                :form="form"
                stay-on
                :redirect="{
                    name: 'EmployeeShowContact',
                    params: { uuid: employee.uuid },
                }"
            >
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.contactNumber"
                            name="contactNumber"
                            :label="$trans('contact.props.contact_number')"
                            v-model:error="formErrors.contactNumber"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.alternateRecords.contactNumber"
                            name="alternateContactNumber"
                            :label="
                                $trans('global.alternate', {
                                    attribute: $trans(
                                        'contact.props.contact_number'
                                    ),
                                })
                            "
                            v-model:error="formErrors.alternateContactNumber"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1"></div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.email"
                            name="email"
                            :label="$trans('contact.props.email')"
                            v-model:error="formErrors.email"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="form.alternateRecords.email"
                            name="alternateEmail"
                            :label="
                                $trans('global.alternate', {
                                    attribute: $trans('contact.props.email'),
                                })
                            "
                            v-model:error="formErrors.alternateEmail"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1"></div>
                    <div class="col-span-3">
                        <BaseFieldset>
                            <template #legend>{{
                                $trans("contact.props.present_address")
                            }}</template>
                            <div class="grid grid-cols-3 gap-6">
                                <AddressInput
                                    prefix="presentAddress"
                                    v-model:addressLine1="
                                        form.presentAddress.addressLine1
                                    "
                                    v-model:addressLine2="
                                        form.presentAddress.addressLine2
                                    "
                                    v-model:city="form.presentAddress.city"
                                    v-model:state="form.presentAddress.state"
                                    v-model:zipcode="
                                        form.presentAddress.zipcode
                                    "
                                    v-model:country="
                                        form.presentAddress.country
                                    "
                                    v-model:formErrors="formErrors"
                                />
                            </div>
                        </BaseFieldset>
                    </div>
                    <div class="col-span-3">
                        <BaseFieldset>
                            <template #legend>{{
                                $trans("contact.props.permanent_address")
                            }}</template>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-1">
                                    <BaseSwitch
                                        v-model="
                                            form.permanentAddress
                                                .sameAsPresentAddress
                                        "
                                        name="sameAsPresentAddress"
                                        :label="
                                            $trans(
                                                'contact.props.same_as_present_address'
                                            )
                                        "
                                        v-model:error="
                                            formErrors.sameAsPresentAddress
                                        "
                                    />
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-3 gap-6">
                                <AddressInput
                                    prefix="permanentAddress"
                                    v-if="
                                        !form.permanentAddress
                                            .sameAsPresentAddress
                                    "
                                    v-model:addressLine1="
                                        form.permanentAddress.addressLine1
                                    "
                                    v-model:addressLine2="
                                        form.permanentAddress.addressLine2
                                    "
                                    v-model:city="form.permanentAddress.city"
                                    v-model:state="form.permanentAddress.state"
                                    v-model:zipcode="
                                        form.permanentAddress.zipcode
                                    "
                                    v-model:country="
                                        form.permanentAddress.country
                                    "
                                    v-model:formErrors="formErrors"
                                />
                            </div>
                        </BaseFieldset>
                    </div>
                </div>
            </FormAction>
        </template>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeEditContact",
}
</script>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initForm = {
    contactNumber: "",
    email: "",
    alternateRecords: {},
    presentAddress: {},
    permanentAddress: {},
}

const initUrl = "employee/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

onMounted(async () => {
    Object.assign(initForm, {
        contactNumber: props.employee.contact.contactNumber,
        email: props.employee.contact.email,
        alternateRecords: {
            contactNumber:
                props.employee.contact.alternateRecords?.contactNumber,
            email: props.employee.contact.alternateRecords?.email,
        },
        presentAddress: {
            addressLine1: props.employee.contact.presentAddress?.addressLine1,
            addressLine2: props.employee.contact.presentAddress?.addressLine2,
            city: props.employee.contact.presentAddress?.city,
            state: props.employee.contact.presentAddress?.state,
            zipcode: props.employee.contact.presentAddress?.zipcode,
            country: props.employee.contact.presentAddress?.country,
        },
        permanentAddress: {
            sameAsPresentAddress: props.employee.contact.sameAsPresentAddress,
            addressLine1: props.employee.contact.permanentAddress?.addressLine1,
            addressLine2: props.employee.contact.permanentAddress?.addressLine2,
            city: props.employee.contact.permanentAddress?.city,
            state: props.employee.contact.permanentAddress?.state,
            zipcode: props.employee.contact.permanentAddress?.zipcode,
            country: props.employee.contact.permanentAddress?.country,
        },
    })

    Object.assign(form, cloneDeep(initForm))
})
</script>
