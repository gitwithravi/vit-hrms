<template>
    <BaseCard :is-loading="isLoading">
        <template #title>{{
            $trans("global.summary", {
                attribute: $trans("attendance.attendance"),
            })
        }}</template>
        <Bar :data="data" :options="options" v-if="data.labels" />
    </BaseCard>
</template>

<script>
export default {
    name: "DashboardChart",
}
</script>

<script setup>
import { onMounted, reactive, ref } from "vue"
import { useStore } from "vuex"
import { Bar } from "vue-chartjs"
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js"

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
)

const store = useStore()

const options = ref({
    responsive: true,
    plugins: {
        legend: {
            position: "bottom",
        },
        tooltip: {
            mode: "index",
            intersect: false,
        },
    },
    scales: {
        x: {
            stacked: true,
            grid: {
                display: false,
            },
        },
        y: {
            stacked: true,
            beginAtZero: true,
            ticks: {
                precision: 0,
            },
        },
    },
})

const isLoading = ref(false)
const data = reactive({})

onMounted(async () => {
    isLoading.value = true

    await store
        .dispatch("dashboard/getChart")
        .then((response) => {
            isLoading.value = false
            Object.assign(data, response)
        })
        .catch(() => {
            isLoading.value = false
        })
})
</script>
