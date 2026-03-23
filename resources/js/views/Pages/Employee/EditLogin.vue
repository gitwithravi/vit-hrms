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
            <template v-if="!state.isValidated">
                <FormAction
                    no-action-button
                    no-data-fetch
                    :init-url="initUrl"
                    action="confirmUser"
                    :init-form="initForm"
                    :form="form"
                    :after-submit="afterValidate"
                    stay-on
                    :redirect="{
                        name: 'EmployeeShowLogin',
                        params: { uuid: employee.uuid },
                    }"
                >
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-1">
                            <BaseInput
                                type="text"
                                v-model="form.email"
                                name="email"
                                :label="$trans('contact.login.props.email')"
                                v-model:error="formErrors.email"
                            />
                        </div>
                    </div>
                    <BaseButton class="mt-4" type="submit">{{
                        $trans("general.validate")
                    }}</BaseButton>
                </FormAction>
            </template>
            <template v-else>
                <FormAction
                    no-data-fetch
                    :pre-requisites="true"
                    :pre-requisite-url="preRequisiteUrl"
                    @setPreRequisites="setPreRequisites"
                    :init-url="initUrl"
                    :action="state.existingUser ? 'updateUser' : 'createUser'"
                    :init-form="initForm"
                    :form="form"
                    :after-submit="afterSubmit"
                >
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-1">
                            <BaseInput
                                readonly
                                disabled
                                type="text"
                                v-model="form.email"
                                name="email"
                                :label="$trans('contact.login.props.email')"
                                v-model:error="formErrors.email"
                            />
                        </div>
                        <template v-if="state.existingUser">
                            <div class="col-span-3 sm:col-span-1">
                                <BaseInput
                                    readonly
                                    disabled
                                    type="text"
                                    v-model="form.username"
                                    name="username"
                                    :label="
                                        $trans('contact.login.props.username')
                                    "
                                    v-model:error="formErrors.username"
                                />
                            </div>
                        </template>

                        <template v-if="!state.existingUser">
                            <div class="col-span-3 sm:col-span-1">
                                <BaseInput
                                    type="text"
                                    v-model="form.username"
                                    name="username"
                                    :label="
                                        $trans('contact.login.props.username')
                                    "
                                    v-model:error="formErrors.username"
                                />
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <BaseInput
                                    type="password"
                                    v-model="form.password"
                                    name="password"
                                    :label="
                                        $trans('contact.login.props.password')
                                    "
                                    v-model:error="formErrors.password"
                                />
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <BaseInput
                                    type="password"
                                    v-model="form.passwordConfirmation"
                                    name="passwordConfirmation"
                                    :label="
                                        $trans(
                                            'contact.login.props.password_confirmation'
                                        )
                                    "
                                    v-model:error="
                                        formErrors.passwordConfirmation
                                    "
                                />
                            </div>
                        </template>

                        <div class="col-span-3 sm:col-span-1">
                            <BaseSelect
                                v-model="form.roles"
                                name="roles"
                                :label="$trans('contact.login.props.role')"
                                :options="preRequisites.roles"
                                multiple
                                label-prop="label"
                                value-prop="uuid"
                                v-model:error="formErrors.roles"
                            />
                        </div>
                    </div>
                </FormAction>
            </template>
        </template>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeEditLogin",
}
</script>

<script setup>
import { reactive, computed, inject, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()
const router = useRouter()

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
    username: "",
    email: "",
    password: "",
    passwordConfirmation: "",
    roles: [],
}

const initUrl = "employee/"
const preRequisiteUrl = "user/"
const preRequisites = reactive({})
const formErrors = getFormErrors(initUrl)
const user = computed(() => props.employee.contact.user)

const state = reactive({
    isValidated: false,
    existingUser: null,
})
const form = reactive({ ...initForm })

const setPreRequisites = (data) => {
    Object.assign(preRequisites, data)
}

const afterValidate = (data) => {
    state.isValidated = true
    state.existingUser = data || null
    form.username = data?.username
}

const afterSubmit = () => {
    emitter.emit("employeeUpdated")
    router.push({
        name: "EmployeeShowLogin",
        params: { uuid: props.employee.uuid },
    })
}

onMounted(async () => {
    state.isValidated = user.value ? true : false
    state.existingUser = user.value
    Object.assign(initForm, {
        username: user.value?.username,
        email: user.value?.email,
        roles: user.value?.roles.map((item) => item.uuid) || [],
    })

    Object.assign(form, cloneDeep(initForm))
})
</script>
