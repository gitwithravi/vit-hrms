<template>
    <BaseLoader :is-loading="isLoading">
        <div class="bg-secondary w-full rounded-lg px-8 py-4">
            <FormWizard
                @complete="finish"
                :next-button-text="$trans('setup.install.next')"
                :previous-button-text="$trans('setup.install.previous')"
                :finish-button-text="$trans('setup.install.finish')"
            >
                <template #header>
                    <p
                        class="text-primary text-center text-xl"
                        v-if="app.title"
                    >
                        {{ app.title + " " + app.version }}
                    </p>
                    <p
                        class="text-dark-primary text-center"
                        v-if="app.subtitle"
                    >
                        {{ app.subtitle }}
                    </p>
                </template>
                <TabContent
                    :title="$trans('setup.install.step', { attribute: 1 })"
                    :description="$trans('setup.install.prerequisite_check')"
                    :before-change="validatePreRequisite"
                >
                    <template v-for="preRequisite in preRequisites">
                        <h6 class="mb-4 text-sm font-medium">
                            {{ preRequisite.title }}
                        </h6>
                        <div class="mb-4 grid grid-cols-6 gap-6">
                            <template v-for="item in preRequisite.items">
                                <div class="col-span-6 sm:col-span-2">
                                    <BaseAlert :design="item.type">{{
                                        item.message
                                    }}</BaseAlert>
                                </div>
                            </template>
                        </div>
                    </template>
                </TabContent>
                <TabContent
                    :title="$trans('setup.install.step', { attribute: 2 })"
                    :description="$trans('setup.install.database_setup')"
                    :before-change="validateDatabase"
                    :after-load="onDatabaseTabLoad"
                >
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <BaseInput
                                type="text"
                                v-model="form.dbHost"
                                name="dbHost"
                                :label="$trans('setup.install.props.db_host')"
                                v-model:error="formErrors.dbHost"
                                autofocus
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <BaseInput
                                type="number"
                                v-model="form.dbPort"
                                name="dbPort"
                                :label="$trans('setup.install.props.db_port')"
                                v-model:error="formErrors.dbPort"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.dbName"
                                name="dbName"
                                :label="$trans('setup.install.props.db_name')"
                                v-model:error="formErrors.dbName"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.dbUsername"
                                name="dbUsername"
                                :label="
                                    $trans('setup.install.props.db_username')
                                "
                                v-model:error="formErrors.dbUsername"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="password"
                                v-model="form.dbPassword"
                                name="dbPassword"
                                :label="
                                    $trans('setup.install.props.db_password')
                                "
                                v-model:error="formErrors.dbPassword"
                            />
                        </div>
                    </div>
                </TabContent>
                <TabContent
                    :title="$trans('setup.install.step', { attribute: 3 })"
                    :description="$trans('setup.install.account_setup')"
                    :before-change="validateUser"
                    :after-load="onUserTabLoad"
                >
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.name"
                                name="name"
                                :label="$trans('setup.install.props.name')"
                                v-model:error="formErrors.name"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="email"
                                v-model="form.email"
                                name="email"
                                :label="$trans('setup.install.props.email')"
                                v-model:error="formErrors.email"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.employeeCode"
                                name="employeeCode"
                                :label="$trans('employee.props.code_number')"
                                v-model:error="formErrors.employeeCode"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.department"
                                name="department"
                                :label="$trans('company.department.department')"
                                v-model:error="formErrors.department"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.designation"
                                name="designation"
                                :label="
                                    $trans('company.designation.designation')
                                "
                                v-model:error="formErrors.designation"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.branch"
                                name="branch"
                                :label="$trans('company.branch.branch')"
                                v-model:error="formErrors.branch"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="text"
                                v-model="form.username"
                                name="username"
                                :label="$trans('setup.install.props.username')"
                                v-model:error="formErrors.username"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="password"
                                v-model="form.password"
                                name="password"
                                :label="$trans('setup.install.props.password')"
                                v-model:error="formErrors.password"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <BaseInput
                                type="password"
                                v-model="form.passwordConfirmation"
                                name="passwordConfirmation"
                                :label="
                                    $trans(
                                        'setup.install.props.password_confirmation'
                                    )
                                "
                                v-model:error="formErrors.passwordConfirmation"
                            />
                        </div>
                    </div>
                </TabContent>
                <TabContent
                    :title="$trans('setup.install.step', { attribute: 4 })"
                    :description="$trans('setup.install.license_validation')"
                    :before-change="validateLicense"
                    :after-load="onLicenseTabLoad"
                >
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <BaseInput
                                type="text"
                                v-model="form.accessCode"
                                name="accessCode"
                                :label="
                                    $trans('setup.license.props.access_code')
                                "
                                v-model:error="formErrors.accessCode"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <BaseInput
                                type="email"
                                v-model="form.registeredEmail"
                                name="registeredEmail"
                                :label="
                                    $trans(
                                        'setup.license.props.registered_email'
                                    )
                                "
                                v-model:error="formErrors.registeredEmail"
                                autofocus
                            />
                        </div>
                    </div>
                </TabContent>
            </FormWizard>
        </div>
    </BaseLoader>
</template>

<script setup>
import { computed, reactive, ref, onMounted } from "vue"
import { useStore } from "vuex"
import { useRouter } from "vue-router"

const store = useStore()
const router = useRouter()

const initForm = {
    dbHost: "localhost",
    dbPort: "3306",
    dbName: "",
    dbUsername: "",
    dbPassword: "",
    name: "",
    email: "",
    username: "",
    password: "",
    passwordConfirmation: "",
    employeeCode: "",
    department: "Administration",
    designation: "Administrator",
    branch: "Head Office",
    accessCode: "",
    registeredEmail: "",
}

const form = reactive(initForm)

const isLoading = ref(null)
const preRequisites = computed(
    () => store.getters["setup/install/getPreRequisites"]
)
const app = computed(() => store.getters["setup/install/getApp"])
const formErrors = computed(() => store.getters["setup/install/getFormErrors"])
const dbHost = ref(null)

onMounted(async () => {
    isLoading.value = true
    await store
        .dispatch("setup/install/fetchPreRequisite", {})
        .then((response) => {
            isLoading.value = false
        })
        .catch((e) => {
            isLoading.value = false
        })
})

const onDatabaseTabLoad = () => {}
const onUserTabLoad = () => {}
const onLicenseTabLoad = () => {}

const validatePreRequisite = () =>
    store.getters["setup/install/hasValidPreRequisite"]
const validateDatabase = () => validate("db")
const validateUser = () => validate("user")
const validateLicense = () => validate("license")

const validate = (option) => {
    isLoading.value = true
    return store
        .dispatch("setup/install/validate", {
            option,
            form,
        })
        .then((response) => {
            isLoading.value = false
            return true
        })
        .catch((e) => {
            isLoading.value = false
            return false
        })
}

const finish = async () => {
    isLoading.value = true
    await store
        .dispatch("setup/install/finish", {
            form,
        })
        .then(() => {
            isLoading.value = false
            router.push({ name: "Login" })
        })
        .catch((e) => {
            isLoading.value = false
        })
}
</script>
