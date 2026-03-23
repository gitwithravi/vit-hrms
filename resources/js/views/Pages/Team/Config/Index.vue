<template>
    <ModuleConfig :navigations="navigations">
        <router-view :team="team" />
    </ModuleConfig>
</template>

<script>
export default {
    name: "TeamConfig",
}
</script>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const route = useRoute()
const router = useRouter()
const store = useStore()

const navigations = [
    {
        name: "TeamConfigGeneral",
        icon: "fas fa-building",
        label: "team.config.general.general",
    },
    // {
    //     name: "TeamConfigAsset",
    //     icon: "fas fa-image",
    //     label: "team.config.asset.asset",
    // },
    {
        name: "TeamConfigRole",
        icon: "fas fa-user-tag",
        label: "team.config.role.role",
    },
    {
        name: "TeamConfigPermission",
        icon: "fas fa-key",
        label: "team.config.permission.permission",
    },
    {
        name: "TeamConfigDfaList",
        icon: "fas fa-building",
        label: "team.config.dfa.dfa",
    },
]

const team = reactive({})

const getItem = async () => {
    await store
        .dispatch("team/get", {
            uuid: route.params.uuid,
        })
        .then((response) => {
            Object.assign(team, response)
        })
        .catch((e) => {
            router.push({ name: "TeamList" })
        })
}

onMounted(async () => {
    await getItem()
})
</script>
