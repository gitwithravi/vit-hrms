<template>
    <PageHeader v-if="team.uuid" :title="$trans(route.meta.label)" :navs="[]">
        <div class="space-x-4">
            <BaseButton
                @click="router.push({ name: 'TeamConfigPermission' })"
                >{{
                    $trans("team.config.permission.role_permission")
                }}</BaseButton
            >
        </div>
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            no-data-fetch
            :init-url="initUrl"
            :uuid="route.params.uuid"
            action="userWiseAssign"
            :init-form="initForm"
            :form="form"
            reset-form
            :keep-adding="false"
        >
            <CardHeader
                first
                :title="$trans('team.config.permission.user_permission_config')"
                :description="
                    $trans('team.config.permission.user_permission_info')
                "
            ></CardHeader>
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <BaseRadioGroup
                        :options="actionOptions"
                        name="action"
                        v-model="form.action"
                        v-model:error="formErrors.action"
                        horizontal
                    />
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <BaseSelect
                        v-model="form.users"
                        :filterResults="false"
                        :minChars="1"
                        :resolveOnLoad="false"
                        :delay="500"
                        multiple
                        name="users"
                        value-prop="uuid"
                        :options="
                            async function (query) {
                                return await searchUser(query)
                            }
                        "
                        :label="
                            $trans('global.select', {
                                attribute: $trans('user.user'),
                            })
                        "
                        v-model:error="formErrors.users"
                    >
                        <template #selectedOption="slotProps">
                            {{ slotProps.value.profile.name }} ({{
                                slotProps.value.email
                            }})
                        </template>

                        <template #listOption="slotProps">
                            {{ slotProps.option.profile.name }} ({{
                                slotProps.option.email
                            }})
                        </template>
                    </BaseSelect>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <BaseSelect
                        v-model="form.permissions"
                        :filterResults="false"
                        :minChars="1"
                        :resolveOnLoad="false"
                        :delay="500"
                        multiple
                        name="permissions"
                        :options="
                            async function (query) {
                                return await search(query)
                            }
                        "
                        :label="
                            $trans('global.select', {
                                attribute: $trans(
                                    'team.config.permission.permission'
                                ),
                            })
                        "
                        v-model:error="formErrors.permissions"
                    />
                </div>
            </div>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "TeamConfigUserPermission",
}
</script>

<script setup>
import { reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { getFormErrors } from "@core/helpers/action"

const route = useRoute()
const router = useRouter()
const store = useStore()

const $trans = inject("$trans")

const props = defineProps({
    team: {
        type: Object,
        default() {
            return {
                name: "",
            }
        },
    },
})

const initUrl = "team/permission/"
const formErrors = getFormErrors(initUrl)

const initForm = {
    action: "",
    users: [],
    permissions: [],
}

const preRequisites = reactive({})
const form = reactive({ ...initForm })

const actionOptions = [
    { label: $trans("general.assign"), value: "assign" },
    { label: $trans("general.revoke"), value: "revoke" },
]

const search = async (query) => {
    return await store
        .dispatch(initUrl + "search", {
            query,
            uuid: route.params.uuid,
        })
        .then((response) => {
            return response
        })
        .catch((e) => {})
}

const searchUser = async (query) => {
    return await store
        .dispatch(initUrl + "searchUser", {
            query,
            uuid: route.params.uuid,
        })
        .then((response) => {
            return response
        })
        .catch((e) => {})
}
</script>
