<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="CompanyDesignation"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('company.designation.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('company.designation.props.alias')"
                    v-model:error="formErrors.alias"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseSelectSearch
                    v-if="fetchData.isLoaded"
                    name="parent"
                    :label="
                        $trans('global.select', {
                            attribute: $trans(
                                'company.designation.props.parent'
                            ),
                        })
                    "
                    v-model="form.parent"
                    v-model:error="formErrors.parent"
                    :init-search="fetchData.parent"
                    search-action="company/designation/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('company.designation.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "CompanyDesignationForm",
}
</script>

<script setup>
import { reactive } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const initForm = {
    name: "",
    alias: "",
    parent: "",
    description: "",
}

const initUrl = "company/designation/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    parent: "",
    isLoaded: route.params.uuid ? false : true,
})

const setForm = (data) => {
    Object.assign(initForm, {
        name: data.name,
        alias: data.alias,
        description: data.description,
        parent: data.parent?.uuid,
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.parent = data.parent?.uuid
    fetchData.isLoaded = true
}
</script>
