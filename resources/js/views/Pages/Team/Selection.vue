<template>
    <div
        v-for="team in teams"
        :key="team.uuid"
        @click="select(team)"
        class="cursor-pointer"
    >
        {{ team.name }}
    </div>
</template>

<script>
export default {
    name: "TeamSelection",
}
</script>

<script setup>
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { getConfig } from "@core/helpers/action"

const route = useRoute()
const router = useRouter()
const store = useStore()

const teams = getConfig("teams")

const select = async (team) => {
    await store
        .dispatch("team/select", {
            uuid: team.uuid,
        })
        .then(async (response) => {
            await store.dispatch("auth/user/fetch")

            router.push(
                route.query.ref ? route.query.ref : { name: "Dashboard" }
            )
        })
        .catch((e) => {})
}
</script>
