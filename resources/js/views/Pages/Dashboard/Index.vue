<template>
    <div v-if="isStaff">
        <div class="bg-black px-4 pb-16 pt-6" v-if="isAdmin || isDfa">
            <DashboardStat />
        </div>
        <BaseFlexContainer class="px-4" :class="(isAdmin || isDfa) ? '-mt-10' : 'mt-5'">
            <BaseFlexCard class="md:w-1/3">
                <DashboardAgenda />
            </BaseFlexCard>
            <BaseFlexCard class="md:w-2/3">
                <DashboardChart />
            </BaseFlexCard>
        </BaseFlexContainer>

        <DashboardRecord />
    </div>
    <div v-else></div>
</template>

<script setup>
import BaseFlexContainer from "@core/components/Ui/BaseFlexContainer.vue";
import BaseFlexCard from "@core/components/Ui/BaseFlexCard.vue";
import { getAuthUser, actingAs } from "@core/helpers/action"
import DashboardStat from "./Stat.vue"
import DashboardAgenda from "./Agenda.vue"
import DashboardChart from "./Chart.vue"
import DashboardRecord from "./Record.vue"

const isStaff = getAuthUser("isStaff")
const isAdmin = actingAs("admin")
const isDfa = actingAs("d-f-a")
</script>
