<template>
    <BaseFlexCard class="md:w-1/3" :is-loading="isLoading">
        <template #title>{{
            $trans("task.dashboard.category_wise_task")
        }}</template>
        <div>
            <Doughnut
                :data="state.categoryWiseData"
                :options="options"
                v-if="state.categoryWiseData?.labels"
            />
        </div>
    </BaseFlexCard>
    <BaseFlexCard class="md:w-1/3" :is-loading="isLoading">
        <template #title>{{
            $trans("task.dashboard.priority_wise_task")
        }}</template>
        <div>
            <Doughnut
                :data="state.priorityWiseData"
                :options="options"
                v-if="state.priorityWiseData?.labels"
            />
        </div>
    </BaseFlexCard>
</template>

<script>
export default {
    name: "DashboadChart",
}
</script>

<script setup>
import { onMounted, reactive, ref } from "vue"
import { useStore } from "vuex"
import { Doughnut } from "vue-chartjs"
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js"

ChartJS.register(ArcElement, Tooltip, Legend)

const store = useStore()

const isLoading = ref(false)
const state = reactive({})

const options = ref({
    responsive: true,
    maintainAspectRatio: false,
})

onMounted(async () => {
    isLoading.value = true

    await store
        .dispatch("task/dashboard/getChart")
        .then((response) => {
            isLoading.value = false
            Object.assign(state, response)
        })
        .catch((e) => {
            isLoading.value = false
        })
})
</script>
