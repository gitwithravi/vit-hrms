<template>
    <ConfigPage>
        <FormAction
            no-card
            no-data-fetch
            :init-url="initUrl"
            action="assignDfaRole"
            :init-form="initForm"
            :form="form"
            reset-form
            :keep-adding="false"
        >
            <CardHeader
                first
                :title="$trans('team.config.dfa.user')"
                :description="$trans('global.assign', {attribute: $trans('team.config.dfa.role')})"
            ></CardHeader>
            <div class="grid grid-cols-2 gap-6">
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
                </div>
            </div>
        </FormAction>

        <ListItem
            :init-url="initUrl"
            @setItems="setItems"
        >
            <DataTable
                :header="users.headers"
                :meta="users.meta"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="user in users.data" :key="user.uuid">
                    <DataCell name="name">
                        {{ user.name }}
                    </DataCell>
                    <DataCell name="email">
                        {{ user.email }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu v-if="!user.isDefault">
                            <FloatingMenuItem
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        moduleUuid: user.uuid,
                                    })
                                "
                            >{{
                                $trans("general.delete")
                            }}</FloatingMenuItem>
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
            </DataTable>
        </ListItem>
    </ConfigPage>
</template>

<script>
export default {
    name: "ConfigDfa",
}
</script>

<script setup>
import { reactive, inject } from "vue"
import { useStore } from "vuex"
import { getFormErrors } from "@core/helpers/action"

const store = useStore()
const emitter = inject("emitter")

const initUrl = "team/dfa/"
const formErrors = getFormErrors(initUrl)

const initForm = {
    users: [],
}

const form = reactive({ ...initForm })

const searchUser = async (query) => {
    return await store
        .dispatch(initUrl + "searchUser", {
            query,
        })
        .then((response) => {
            return response
        })
        .catch((e) => {})
}

const users = reactive({})
const setItems = (data) => {
    Object.assign(users, data)
}
</script>
