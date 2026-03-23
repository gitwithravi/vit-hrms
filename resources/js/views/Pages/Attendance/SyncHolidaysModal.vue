<template>
    <BaseModal :visibility="visibility" @close="emit('close')">
        <template #title>Sync Holidays</template>

        <div class="space-y-4">
            <div>
                <DatePicker
                    as="range"
                    v-model:start="form.start_date"
                    v-model:end="form.end_date"
                    name="dateRange"
                    label="Date Range"
                    v-model:error="formErrors.start_date"
                />
            </div>
            <div>
                <BaseSelect
                    v-model="form.attendance_type_uuid"
                    name="attendance_type_uuid"
                    label="Attendance Type"
                    :options="preRequisites.attendanceTypes"
                    value-prop="uuid"
                    label-prop="name"
                    v-model:error="formErrors.attendance_type_uuid"
                />
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <BaseButton
                design="white"
                :disabled="isLoading"
                :class="{ 'pointer-events-none opacity-50': isLoading }"
                @click="emit('close')"
            >
                Cancel
            </BaseButton>
            <BaseButton
                design="primary"
                :disabled="isLoading"
                :class="{ 'pointer-events-none': isLoading }"
                @click="submit"
            >
                <i v-if="isLoading" class="fas fa-spinner fa-spin mr-2"></i>
                Submit
            </BaseButton>
        </div>
    </BaseModal>
</template>

<script>
export default {
    name: "SyncHolidaysModal",
}
</script>

<script setup>
import { ref, reactive, onMounted } from "vue"
import { useStore } from "vuex"
import { getFormErrors } from "@core/helpers/action"

const emit = defineEmits(["close", "completed"])

const props = defineProps({
    visibility: {
        type: Boolean,
        default: false,
    },
})

const store = useStore()

const initUrl = "attendance/"

const form = reactive({
    start_date: "",
    end_date: "",
    attendance_type_uuid: "",
})

const preRequisites = reactive({
    attendanceTypes: [],
})

const formErrors = getFormErrors(initUrl)
const isLoading = ref(false)

const submit = async () => {
    if (isLoading.value) return
    isLoading.value = true
    await store
        .dispatch(initUrl + "syncHolidays", { form })
        .then(() => {
            isLoading.value = false
            emit("completed")
            emit("close")
        })
        .catch(() => {
            isLoading.value = false
        })
}

onMounted(async () => {
    await store
        .dispatch(initUrl + "preRequisite")
        .then((response) => {
            preRequisites.attendanceTypes = response.attendanceTypes
        })
        .catch(() => {})
})
</script>
