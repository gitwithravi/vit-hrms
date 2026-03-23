<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[{ label: $trans('task.task'), path: 'Task' }]"
    >
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            :pre-requisites="{ data: ['datePlaceholders'] }"
            @setPreRequisites="setPreRequisites"
            :init-url="initUrl"
            data-fetch="task"
            action="store"
            :init-form="initForm"
            :form="form"
            stay-on
            redirect="Task"
        >
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeNumberPrefix"
                        name="codeNumberPrefix"
                        :label="$trans('task.config.props.number_prefix')"
                        v-model:error="formErrors.codeNumberPrefix"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="number"
                        v-model="form.codeNumberDigit"
                        name="codeNumberDigit"
                        :label="$trans('task.config.props.number_digit')"
                        v-model:error="formErrors.codeNumberDigit"
                    />
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <BaseInput
                        type="text"
                        v-model="form.codeNumberSuffix"
                        name="codeNumberSuffix"
                        :label="$trans('task.config.props.number_suffix')"
                        v-model:error="formErrors.codeNumberSuffix"
                    />
                </div>
                <div class="col-span-3">
                    <BaseAlert design="info">{{
                        datePlaceholderInfo
                    }}</BaseAlert>
                </div>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-4">
                <div class="col-span-3 sm:col-span-1">
                    <BaseLabel>{{
                        $trans("task.config.props.view")
                    }}</BaseLabel>
                    <BaseRadioGroup
                        top-margin
                        :options="[
                            {
                                label: $trans('task.config.views.list'),
                                value: 'list',
                            },
                            {
                                label: $trans('task.config.views.card'),
                                value: 'card',
                            },
                            {
                                label: $trans('task.config.views.board'),
                                value: 'board',
                            },
                        ]"
                        name="view"
                        v-model="form.view"
                        v-model:error="formErrors.view"
                        horizontal
                    />
                </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.isAccessibleToTopLevel"
                        name="isAccessibleToTopLevel"
                        :label="
                            $trans(
                                'task.config.props.is_accessible_to_top_level'
                            )
                        "
                        v-model:error="formErrors.isAccessibleToTopLevel"
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <BaseSwitch
                        vertical
                        v-model="form.isManageableByTopLevel"
                        name="isManageableByTopLevel"
                        :label="
                            $trans(
                                'task.config.props.is_manageable_by_top_level'
                            )
                        "
                        v-model:error="formErrors.isManageableByTopLevel"
                    />
                </div>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "TaskConfigGeneral",
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
    codeNumberPrefix: "",
    codeNumberDigit: "",
    codeNumberSuffix: "",
    view: "",
    isAccessibleToTopLevel: false,
    isManageableByTopLevel: false,
    type: "task",
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
