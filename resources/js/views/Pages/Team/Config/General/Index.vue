<template>
    <PageHeader
        v-if="team.uuid"
        :title="$trans(route.meta.label)"
        :navs="[
            { label: $trans('team.team'), path: 'TeamList' },
            {
                label: team.name,
                path: {
                    name: 'TeamShow',
                    params: { uuid: team.uuid },
                },
            },
            { label: $trans('team.config.config'), path: 'TeamConfig' },
        ]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :init-url="initUrl"
            no-data-fetch
            :init-form="initForm"
            :form="form"
            action="storeConfig"
            stay-on
            :redirect="{ name: 'TeamConfig', params: { uuid: team.uuid } }"
        >
            <CardHeader
                first
                :title="$trans('team.config.general.about')"
                :description="$trans('team.config.general.about_info')"
            ></CardHeader>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.name"
                        name="name"
                        :label="$trans('team.config.general.props.name')"
                        v-model:error="formErrors.name"
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.title1"
                        name="title1"
                        :label="$trans('team.config.general.props.title1')"
                        v-model:error="formErrors.title1"
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.title2"
                        name="title2"
                        :label="$trans('team.config.general.props.title2')"
                        v-model:error="formErrors.title2"
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.title3"
                        name="title3"
                        :label="$trans('team.config.general.props.title3')"
                        v-model:error="formErrors.title3"
                    />
                </div>
            </div>

            <CardHeader
                :title="$trans('team.config.general.address')"
                :description="$trans('team.config.general.address_info')"
            ></CardHeader>
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.addressLine1"
                        name="addressLine1"
                        :label="
                            $trans('team.config.general.props.address_line1')
                        "
                        v-model:error="formErrors.addressLine1"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.addressLine2"
                        name="addressLine2"
                        :label="
                            $trans('team.config.general.props.address_line2')
                        "
                        v-model:error="formErrors.addressLine2"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.city"
                        name="city"
                        :label="$trans('team.config.general.props.city')"
                        v-model:error="formErrors.city"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.state"
                        name="state"
                        :label="$trans('team.config.general.props.state')"
                        v-model:error="formErrors.state"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.zipcode"
                        name="zipcode"
                        :label="$trans('team.config.general.props.zipcode')"
                        v-model:error="formErrors.zipcode"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.country"
                        name="country"
                        :label="$trans('team.config.general.props.country')"
                        v-model:error="formErrors.country"
                    />
                </div>
            </div>
            <CardHeader
                :title="$trans('team.config.general.contact')"
                :description="$trans('team.config.general.contact_info')"
            ></CardHeader>
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.email"
                        name="email"
                        :label="$trans('team.config.general.props.email')"
                        v-model:error="formErrors.email"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.phone"
                        name="phone"
                        :label="$trans('team.config.general.props.phone')"
                        v-model:error="formErrors.phone"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.fax"
                        name="fax"
                        :label="$trans('team.config.general.props.fax')"
                        v-model:error="formErrors.fax"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.website"
                        name="website"
                        :label="$trans('team.config.general.props.website')"
                        v-model:error="formErrors.website"
                    />
                </div>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
  name: "TeamConfigGeneral"
}
</script>

<script setup>
import { inject, reactive, watch, onMounted } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const $trans = inject("$trans")

const props = defineProps({
    team: {
        type: Object,
        default() {
            return {
                name: "",
            }
        },
    },
})

const initUrl = "team/"
const formErrors = getFormErrors(initUrl)

const initForm = {
    name: "",
    title1: "",
    title2: "",
    title3: "",
    email: "",
    phone: "",
    fax: "",
    website: "",
    addressLine1: "",
    addressLine2: "",
    city: "",
    state: "",
    zipcode: "",
    country: "",
}

const form = reactive({ ...initForm })

watch(
    () => props.team.config,
    (value) => {
        Object.assign(initForm, cloneDeep(value))
        Object.assign(form, cloneDeep(initForm))
    }
)

onMounted(() => {
    //
})
</script>
