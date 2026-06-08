<template>
    <PageHeader
        v-if="employee.uuid"
        :title="$trans(route.meta.label)"
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
    />

    <ParentTransition appear :visibility="true">
        <BaseLoader :is-loading="isLoading">
            <div class="space-y-6">
                <BaseAlert v-if="!canEdit" design="warning">
                    {{ $trans("employee.mediclaim.edit_disabled_info") }}
                </BaseAlert>

                <BaseAlert v-if="canEdit" design="info">
                    You can add up to 5 dependants, adding all the 5 dependants is not mandatory.
                </BaseAlert>

                <div class="space-y-4">
                    <template v-if="form.dependants.length">
                        <BaseCard
                            v-for="(dependant, index) in form.dependants"
                            :key="dependant.key"
                        >
                        <template #title>
                            {{ $trans("employee.mediclaim.dependant") }}
                            {{ index + 1 }}
                        </template>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <BaseInput
                                    type="text"
                                    v-model="dependant.name"
                                    :disabled="!canEdit"
                                    :name="`dependants.${index}.name`"
                                    :label="
                                        $trans('employee.mediclaim.props.name')
                                    "
                                    :error="getError(index, 'name')"
                                    @update:error="clearError(index, 'name')"
                                />
                            </div>
                            <div>
                                <BaseSelect
                                    v-model="dependant.relationship"
                                    :disabled="!canEdit"
                                    :name="`dependants.${index}.relationship`"
                                    :label="
                                        $trans(
                                            'employee.mediclaim.props.relationship'
                                        )
                                    "
                                    :options="relationships"
                                    :error="getError(index, 'relationship')"
                                    @update:error="
                                        clearError(index, 'relationship')
                                    "
                                />
                            </div>
                            <div>
                                <BaseLabel>
                                    {{ $trans("employee.mediclaim.props.gender") }}
                                </BaseLabel>
                                <BaseRadioGroup
                                    top-margin
                                    horizontal
                                    v-model="dependant.gender"
                                    :disabled="!canEdit"
                                    :name="`dependants.${index}.gender`"
                                    :options="genders"
                                    :error="getError(index, 'gender')"
                                    @update:error="
                                        clearError(index, 'gender')
                                    "
                                />
                            </div>
                            <div>
                                <DatePicker
                                    v-model="dependant.dob"
                                    :disabled="!canEdit"
                                    :name="`dependants.${index}.dob`"
                                    :label="
                                        $trans('employee.mediclaim.props.dob')
                                    "
                                    :error="getError(index, 'dob')"
                                    @update:error="clearError(index, 'dob')"
                                />
                            </div>
                        </div>
                    </BaseCard>
                    </template>
                    <TextMuted v-else>
                        No dependants added.
                    </TextMuted>
                </div>

                <BaseCard>
                    <template #title>
                        {{ $trans("employee.mediclaim.props.top_up") }}
                    </template>
                    <BaseRadioGroup
                        horizontal
                        v-model="form.top_up"
                        :disabled="!canEdit"
                        name="top_up"
                        :options="topUpOptions"
                        :error="formErrors.top_up"
                        @update:error="delete formErrors.top_up"
                    />
                </BaseCard>

                <div class="flex flex-wrap gap-4" v-if="canEdit">
                    <BaseButton :disabled="isSubmitting" @click="submit">
                        {{ $trans("general.save") }}
                    </BaseButton>
                </div>
            </div>
        </BaseLoader>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeMediclaimDependants",
}
</script>

<script setup>
import { onMounted, reactive, ref, watch } from "vue"
import { useRoute } from "vue-router"
import { useToast } from "vue-toastification"
import * as Api from "@core/apis"
import * as Form from "@core/utils/form"

const route = useRoute()
const toast = useToast()

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const isLoading = ref(false)
const isSubmitting = ref(false)
const canEdit = ref(false)
const relationships = ref([])
const genders = ref([])
const topUpOptions = ref([])
const formErrors = reactive({})

const form = reactive({
    top_up: "",
    dependants: [],
})

const maxDependants = 5

const newDependant = () => ({
    key: Math.random().toString(16).slice(2),
    name: "",
    relationship: "",
    gender: "",
    dob: "",
})

const mapDependant = (dependant) => ({
    key: dependant.uuid || Math.random().toString(16).slice(2),
    name: dependant.name || "",
    relationship: dependant.relationship || "",
    gender: dependant.gender || "",
    dob: dependant.dob?.value || "",
})

const fillDependantSlots = (dependants = []) => {
    const rows = dependants.slice(0, maxDependants).map(mapDependant)

    while (rows.length < maxDependants) {
        rows.push(newDependant())
    }

    return rows
}

const setErrors = (errors = {}) => {
    Object.keys(formErrors).forEach((key) => delete formErrors[key])
    Object.assign(formErrors, errors)
}

const getError = (index, field) => {
    return formErrors[`dependants.${index}.${field}`] || ""
}

const clearError = (index, field) => {
    delete formErrors[`dependants.${index}.${field}`]
}

const getUrl = () => `/app/employees/${props.employee.uuid}/mediclaim-dependants`

const fetchDependants = async () => {
    if (!props.employee.uuid) {
        return
    }

    isLoading.value = true
    await Api.custom({
        url: getUrl(),
        method: "GET",
    })
        .then((response) => {
            relationships.value = response.relationships || []
            genders.value = response.genders || []
            topUpOptions.value = response.topUpOptions || []
            canEdit.value = response.canEdit
            form.top_up = response.topUp || ""
            form.dependants = canEdit.value
                ? fillDependantSlots(response.dependants || [])
                : (response.dependants || []).map(mapDependant)
            setErrors()
        })
        .catch((error) => {
            setErrors(Form.getErrors(error))
        })
        .finally(() => {
            isLoading.value = false
        })
}

const submit = async () => {
    isSubmitting.value = true
    await Api.custom({
        url: getUrl(),
        method: "PUT",
        data: {
            top_up: form.top_up,
            dependants: form.dependants.map((dependant) => ({
                name: dependant.name,
                relationship: dependant.relationship,
                gender: dependant.gender,
                dob: dependant.dob,
            })),
        },
    })
        .then((response) => {
            toast.success(response.message)
            form.top_up = response.topUp || ""
            form.dependants = fillDependantSlots(response.dependants || [])
            setErrors()
        })
        .catch((error) => {
            setErrors(Form.getErrors(error))
        })
        .finally(() => {
            isSubmitting.value = false
        })
}

watch(
    () => props.employee.uuid,
    (value, oldValue) => {
        if (value && value !== oldValue) {
            fetchDependants()
        }
    }
)

onMounted(() => {
    fetchDependants()
})
</script>
