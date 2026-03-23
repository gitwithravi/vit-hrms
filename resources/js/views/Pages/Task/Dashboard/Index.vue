<template>
    <div>
        <div class="bg-black px-4 pb-16 pt-6">
            <DashboardStat />
        </div>
        <BaseFlexContainer class="-mt-10 px-4">
            <DashboardFavorite />
            <DashboardChart />
        </BaseFlexContainer>

        <BaseFlexContainer class="mt-4 px-4">
            <BaseFlexCard class="w-full">
                <DashboardRecord />
            </BaseFlexCard>
        </BaseFlexContainer>
    </div>
</template>

<script setup>
import DashboardStat from "./Stat.vue"
import DashboardFavorite from "./Favorite.vue"
import DashboardChart from "./Chart.vue"
import DashboardRecord from "./Record.vue"
</script>
