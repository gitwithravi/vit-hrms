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
        <BaseCard v-if="employee.uuid">
            <div class="grid grid-cols-1">
                <div class="col-span-1">
                    <ImageUpload
                        :label="$trans('contact.props.photo')"
                        :src="form.photo"
                        :upload-path="`employees/${employee.uuid}/photo`"
                        :remove-path="`employees/${employee.uuid}/photo`"
                        @uploaded="uploaded"
                        @removed="removed"
                    />
                </div>
            </div>
        </BaseCard>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeEditPhoto",
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
    photo: "",
}

const initUrl = "employee/"
const formErrors = getFormErrors(initUrl)

const form = reactive({ ...initForm })

const uploaded = async () => {
    emitter.emit("employeeUpdated")
}

const removed = async () => {
    emitter.emit("employeeUpdated")
}

onMounted(async () => {
    Object.assign(initForm, {
        photo: props.employee.contact.photo,
    })

    Object.assign(form, cloneDeep(initForm))
})
</script>
