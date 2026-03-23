<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('leave.leave'), path: 'Leave' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :pre-requisites="{ data: ['datePlaceholders'] }"
            @setPreRequisites="setPreRequisites"
            :init-url="initUrl"
            data-fetch="leave"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Leave"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1"></div>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "LeaveConfigGeneral",
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
    type: "leave",
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
