<template>
    <PageHeader :title="$trans(route.meta.title)" :navs="[]"> </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            no-action-button
            action="license"
            :init-url="initUrl"
            :init-form="initForm"
            :form="form"
            :after-submit="afterSubmit"
        >
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.accessCode"
                        name="accessCode"
                        :label="$trans('setup.license.props.access_code')"
                        v-model:error="formErrors.accessCode"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.email"
                        name="email"
                        :label="$trans('setup.license.props.registered_email')"
                        v-model:error="formErrors.email"
                    />
                </div>
            </div>

            <div class="mt-4">
                <BaseButton design="primary" type="submit">{{
                    $trans("general.proceed")
                }}</BaseButton>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "License",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    accessCode: "",
    email: "",
}

const initUrl = "product/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const afterSubmit = () => {
    location.reload()
}
</script>
