<template>
    <FormAction
        no-data-fetch
        :init-url="initUrl"
        :uuid="route.params.uuid"
        :init-form="initForm"
        :form="form"
        :redirect="{
            name: 'TeamConfigRole',
            params: { uuid: route.params.uuid },
        }"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('team.config.role.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "RoleForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
}

const initUrl = "team/role/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
</script>
