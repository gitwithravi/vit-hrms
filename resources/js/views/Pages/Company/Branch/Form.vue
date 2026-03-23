<template>
    <FormAction
        :init-url="initUrl"
        :init-form="initForm"
        :form="form"
        :set-form="setForm"
        redirect="CompanyBranch"
    >
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.name"
                    name="name"
                    :label="$trans('company.branch.props.name')"
                    v-model:error="formErrors.name"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.code"
                    name="code"
                    :label="$trans('company.branch.props.code')"
                    v-model:error="formErrors.code"
                    autofocus
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseInput
                    type="text"
                    v-model="form.alias"
                    name="alias"
                    :label="$trans('company.branch.props.alias')"
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
                            attribute: $trans('company.branch.props.parent'),
                        })
                    "
                    v-model="form.parent"
                    v-model:error="formErrors.parent"
                    :init-search="fetchData.parent"
                    search-action="company/branch/list"
                />
            </div>
            <div class="col-span-3 sm:col-span-1">
                <BaseTextarea
                    v-model="form.description"
                    name="description"
                    :label="$trans('company.branch.props.description')"
                    v-model:error="formErrors.description"
                />
            </div>
        </div>
    </FormAction>
</template>

<script>
export default {
    name: "CompanyBranchForm",
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
    code: "",
    alias: "",
    parent: "",
    description: "",
}

const initUrl = "company/branch/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
const fetchData = reactive({
    parent: "",
    isLoaded: route.params.uuid ? false : true,
})

const setForm = (data) => {
    Object.assign(initForm, {
        name: data.name,
        code: data.code,
        alias: data.alias,
        description: data.description,
        parent: data.parent?.uuid,
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.parent = data.parent?.uuid
    fetchData.isLoaded = true
}
</script>
