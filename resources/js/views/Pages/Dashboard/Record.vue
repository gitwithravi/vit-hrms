<template>
    <BaseFlexContainer class="mt-4 px-4">
        <BaseFlexCard class="md:w-1/2">
            <LeaveRequestRecord :records="records.leaveRequests" />
        </BaseFlexCard>
        <BaseFlexCard class="md:w-1/2">
            <PayrollRecord :records="records.payrolls" />
        </BaseFlexCard>
    </BaseFlexContainer>
</template>

<script>
export default {
    name: "DashboardRecord",
}
</script>

<script setup>
import { onMounted, reactive, ref } from "vue"
import { useStore } from "vuex"
import LeaveRequestRecord from "./LeaveRequestRecord.vue"
import PayrollRecord from "./PayrollRecord.vue"

const store = useStore()

const isLoading = ref(false)
const records = reactive({})

onMounted(async () => {
    isLoading.value = true

    await store
        .dispatch("dashboard/getRecord")
        .then((response) => {
            isLoading.value = false
            Object.assign(records, response)
        })
        .catch((e) => {
            isLoading.value = false
        })
})
</script>
