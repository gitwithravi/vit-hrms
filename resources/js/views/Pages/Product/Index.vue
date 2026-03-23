<template>
    <PageHeader :title="$trans(route.meta.title)" :navs="[]">
        <PageHeaderAction>
            <BaseButton
                v-if="product.isDownloaded"
                design="primary"
                @click="update"
                >Update</BaseButton
            >
        </PageHeaderAction>
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <BaseCard :is-loading="isLoading">
            <BaseAlert v-if="isLoading" design="info" size="xs">{{
                $trans("general.infos.loading")
            }}</BaseAlert>
            <BaseAlert
                v-if="!isLoading && !product.name"
                design="error"
                size="xs"
                >{{
                    $trans("general.errors.something_wrong_contact_author")
                }}</BaseAlert
            >

            <dl
                class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3"
                v-if="product.name"
            >
                <BaseDataView label="Name">
                    {{ product.name }}
                </BaseDataView>

                <BaseDataView label="Current Version">
                    {{ product.currentVersion }}
                </BaseDataView>

                <BaseDataView label="Latest Version">
                    {{ product.latestVersion }}
                    <BaseBadge design="success" v-if="product.isUpdateAvailable"
                        >Update Available</BaseBadge
                    >
                    <BaseBadge design="info" v-else
                        >No Update Available</BaseBadge
                    >
                </BaseDataView>

                <BaseDataView label="Purchase Date">
                    {{ product.dateOfPurchase.formatted }}
                </BaseDataView>

                <BaseDataView label="Date of Support Expiry">
                    <template v-if="product.isSupportExpired">
                        <BaseBadge design="error">Support Expired</BaseBadge>
                    </template>
                    <template v-else>
                        {{ product.dateOfSupportExpiry?.formatted || "-" }}
                    </template>
                </BaseDataView>

                <BaseDataView label="License Type">
                    {{ product.licenseType }}
                </BaseDataView>

                <BaseDataView label="Purchase Code">
                    {{ product.purchaseCode }}
                </BaseDataView>

                <BaseDataView label="Access Code">
                    {{ product.accessCode }}
                </BaseDataView>

                <BaseDataView label="Registered Email">
                    {{ product.email }}
                </BaseDataView>
            </dl>
        </BaseCard>
    </ParentTransition>
</template>

<script>
export default {
    name: "Product",
}
</script>

<script setup>
import { reactive, ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { useStore } from "vuex"

const route = useRoute()
const store = useStore()

const initUrl = "product/"

const isLoading = ref(false)
const product = reactive({})

const update = async () => {
    isLoading.value = true
    await store
        .dispatch(initUrl + "update")
        .then((response) => {
            location.reload()
            isLoading.value = false
        })
        .catch((e) => {
            isLoading.value = false
        })
}

onMounted(async () => {
    isLoading.value = true
    await store
        .dispatch(initUrl + "info")
        .then((response) => {
            Object.assign(product, response)
            isLoading.value = false
        })
        .catch((e) => {
            isLoading.value = false
        })
})
</script>
