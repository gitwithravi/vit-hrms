<template>
    <BaseModal :visibility="visibility" @close="emit('close')">
        <template #title>Download Attendance Report</template>

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
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <BaseButton design="white" @click="emit('close')">Cancel</BaseButton>
            <BaseButton design="primary" @click="submit">
                <i class="fas fa-download mr-2"></i> Download Excel
            </BaseButton>
        </div>
    </BaseModal>
</template>

<script>
export default {
    name: "AttendanceReportModal",
}
</script>

<script setup>
import { reactive } from "vue"

const emit = defineEmits(["close"])

const props = defineProps({
    visibility: {
        type: Boolean,
        default: false,
    },
})

const form = reactive({
    start_date: "",
    end_date: "",
})

const formErrors = reactive({
    start_date: "",
})

const submit = () => {
    if (!form.start_date || !form.end_date) {
        formErrors.start_date = "Please select a date range."
        return
    }
    formErrors.start_date = ""
    window.open(
        `/app/attendance/report?start_date=${form.start_date}&end_date=${form.end_date}&output=excel`,
        "_blank"
    )
    emit("close")
}
</script>
