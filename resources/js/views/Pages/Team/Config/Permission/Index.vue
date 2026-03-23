<template>
    <PageHeader v-if="team.uuid" :title="$trans(route.meta.label)" :navs="[]">
        <div class="space-x-4">
            <DropdownButton
                direction="down"
                v-if="preRequisites.modules.length"
                :label="$trans('module.' + preRequisites.selectedModule)"
            >
                <div
                    v-for="userModule in preRequisites.modules"
                    :key="userModule.value"
                >
                    <template v-if="userModule.value != route.params.module">
                        <DropdownItem
                            as="span"
                            @click="changeModule(userModule.value)"
                        >
                            {{ userModule.label }}
                        </DropdownItem>
                    </template>
                </div>
            </DropdownButton>
            <BaseButton
                @click="router.push({ name: 'TeamConfigUserPermission' })"
                >{{
                    $trans("team.config.permission.user_permission")
                }}</BaseButton
            >
        </div>
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FormAction
            no-data-fetch
            :init-url="initUrl"
            :uuid="route.params.uuid"
            action="roleWiseAssign"
            :init-form="initForm"
            :form="form"
            stay-on
        >
            <CardHeader
                first
                :title="$trans('team.config.permission.permission_config')"
                :description="$trans('team.config.permission.permission_info')"
            ></CardHeader>

            <BaseLoader :is-loading="isLoading">
                <div
                    class="border border-gray-200 dark:border-gray-700 sm:rounded-lg scroller-thin-x scroller-hidden scrollbar-track-transparent scrollbar-thumb-body dark:scrollbar-thumb-dm-body"
                >
                    <table
                        class="table min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                        v-if="form.assignedPermissions.length"
                    >
                        <thead class="bg-gray-50 dark:bg-neutral-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                                >
                                    {{
                                        $trans(
                                            "team.config.permission.permission"
                                        )
                                    }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                                    v-for="role in preRequisites.roles"
                                >
                                    {{ role.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="dark:bg-dark-body divide-y divide-gray-200 bg-white dark:divide-gray-700"
                        >
                            <tr
                                v-for="assignedPermission in form.assignedPermissions"
                                :key="assignedPermission.name"
                            >
                                <td
                                    class="py-2 pl-6 text-sm text-gray-500 dark:text-gray-400"
                                >
                                    {{ assignedPermission.name }}
                                </td>
                                <td
                                    class="py-2 pl-6 text-sm text-gray-500 dark:text-gray-400"
                                    v-for="role in assignedPermission.roles"
                                >
                                    <BaseCheckbox v-model="role.isAssigned" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </BaseLoader>
        </FormAction>
    </ParentTransition>
</template>

<script>
export default {
    name: "TeamConfigPermissionAssign",
}
</script>

<script setup>
import { reactive, onMounted, ref, watch } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"

const route = useRoute()
const router = useRouter()
const store = useStore()

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

const isLoading = ref(false)
const initUrl = "team/permission/"
const preRequisites = reactive({
    modules: [],
})
const initForm = {
    selectedModule: "",
    assignedPermissions: [],
}

const form = reactive({ ...initForm })

const changeModule = (value) => {
    router.push({
        name: "TeamConfigPermissionAssignModule",
        params: { module: value },
    })
}

const getPreRequisites = async () => {
    isLoading.value = true
    await store
        .dispatch(initUrl + "preRequisite", {
            uuid: route.params.uuid,
            data: route.params.module || "general",
        })
        .then((response) => {
            isLoading.value = false
            Object.assign(preRequisites, {
                modules: response.modules,
                selectedModule: response.selectedModule,
                roles: response.roles,
            })
            initForm.selectedModule = response.selectedModule
            initForm.assignedPermissions = response.assignedPermissions
            Object.assign(form, cloneDeep(initForm))
        })
        .catch((e) => {
            isLoading.value = false
        })
}

watch(
    () => route.params.module,
    (newValue) => {
        if (newValue) {
            initForm.selectedModule = newValue
            Object.assign(form, cloneDeep(initForm))
            getPreRequisites()
        }
    }
)

onMounted(() => {
    getPreRequisites()
})
</script>
