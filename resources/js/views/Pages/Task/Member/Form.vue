<template>
    <BaseSideover :visibility="visibility" @close="emit('close')">
        <template #title>
            <span>{{
                $trans("global.add", {
                    attribute: $trans("task.member.member"),
                })
            }}</span>
        </template>
        <FormAction
            sideover
            no-card
            no-data-fetch
            cancel-action
            action="create"
            :init-url="initUrl"
            :init-form="initForm"
            :form="form"
            @end="emit('close')"
            @completed="emit('completed')"
            @cancelled="emit('close')"
        >
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <BaseSelectSearch
                        multiple
                        name="employees"
                        :label="
                            $trans('global.select', {
                                attribute: $trans('employee.employee'),
                            })
                        "
                        v-model="form.employees"
                        v-model:error="formErrors.employees"
                        value-prop="uuid"
                        :init-search="[]"
                        search-key="name"
                        search-action="employee/list"
                    >
                        <template #selectedOption="slotProps">
                            {{ slotProps.value.name }} ({{
                                slotProps.value.codeNumber
                            }})
                        </template>

                        <template #listOption="slotProps">
                            {{ slotProps.option.name }} ({{
                                slotProps.option.codeNumber
                            }})
                        </template>
                    </BaseSelectSearch>
                </div>
                <div class="col-span-2 space-y-2">
                    <BaseSwitch
                        reverse
                        v-model="form.manageMember"
                        name="manageMember"
                        :label="$trans('task.member.props.manage_member')"
                        v-model:error="formErrors.manageMember"
                    />
                    <BaseSwitch
                        reverse
                        v-model="form.manageChecklist"
                        name="manageChecklist"
                        :label="$trans('task.member.props.manage_checklist')"
                        v-model:error="formErrors.manageChecklist"
                    />
                    <BaseSwitch
                        reverse
                        v-model="form.manageMedia"
                        name="manageMedia"
                        :label="$trans('task.member.props.manage_media')"
                        v-model:error="formErrors.manageMedia"
                    />
                    <BaseSwitch
                        reverse
                        v-model="form.manageCompletion"
                        name="manageCompletion"
                        :label="$trans('task.member.props.manage_completion')"
                        v-model:error="formErrors.manageCompletion"
                    />
                    <BaseSwitch
                        reverse
                        v-model="form.manageTaskList"
                        name="manageTaskList"
                        :label="$trans('task.member.props.manage_task_list')"
                        v-model:error="formErrors.manageTaskList"
                    />
                </div>
            </div>
        </FormAction>
    </BaseSideover>
</template>

<script>
export default {
    name: "TaskMemberForm",
}
</script>

<script setup>
import { reactive, watch } from "vue"
import { useRoute } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()

const emit = defineEmits(["close", "completed"])

const props = defineProps({
    visibility: {
        type: Boolean,
        default: false,
    },
})

const initForm = {
    employees: [],
    manageMember: false,
    manageChecklist: false,
    manageMedia: false,
    manageCompletion: false,
    manageTaskList: false,
}

const initUrl = "task/member/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })
</script>
