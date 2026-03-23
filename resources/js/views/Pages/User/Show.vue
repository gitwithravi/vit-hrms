<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('user.user'), path: 'User' }]"
    >
        <PageHeaderAction
            name="User"
            :title="$trans('user.user')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'User' })"
        >
            <BaseCard v-if="user.uuid">
                <template #title>
                    {{ user.profile.name }}
                    <BaseBadge
                        :label="user.status.label"
                        :design="user.status.color"
                    />
                </template>
                <template #action>
                    <div class="flex space-x-4" v-if="perform('user:edit')">
                        <template
                            v-if="user.status.value == 'pending_approval'"
                        >
                            <BaseButton
                                size="xs"
                                design="success"
                                @click="updateStatus('activated')"
                            >
                                {{ $trans("user.status_action.activate") }}
                            </BaseButton>
                            <BaseButton
                                size="xs"
                                design="danger"
                                @click="updateStatus('disapproved')"
                            >
                                {{ $trans("user.status_action.disapprove") }}
                            </BaseButton>
                        </template>
                        <template v-if="user.status.value == 'activated'">
                            <BaseButton
                                size="xs"
                                design="danger"
                                @click="updateStatus('banned')"
                            >
                                {{ $trans("user.status_action.ban") }}
                            </BaseButton>
                        </template>
                        <template v-if="user.status.value == 'banned'">
                            <BaseButton
                                size="xs"
                                design="success"
                                @click="updateStatus('activated')"
                            >
                                {{ $trans("user.status_action.activate") }}
                            </BaseButton>
                        </template>
                    </div>
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('user.props.email')">
                        {{ user.email }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('user.props.username')">
                        {{ user.username }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('config.role.role')"
                        class="col-span-1 sm:col-span-2"
                    >
                        <div v-for="role in user.roles">
                            <BaseBadge :label="role.label" />
                        </div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ user.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ user.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            v-if="perform('user:edit')"
                            @click="
                                router.push({
                                    name: 'UserEdit',
                                    params: { uuid: user.uuid },
                                })
                            "
                        >
                            {{ $trans("general.edit") }}
                        </BaseButton>
                    </ShowButton>
                </template>
            </BaseCard>
        </ShowItem>
    </ParentTransition>
</template>

<script>
export default {
    name: "UserShow",
}
</script>

<script setup>
import { reactive, computed, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const emitter = inject("emitter")

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialUser = {}

const initUrl = "user/"

const user = reactive({ ...initialUser })

const setItem = (data) => {
    Object.assign(user, data)
}

const updateStatus = async (status) => {
    emitter.emit("showActionItem", {
        uuid: user.uuid,
        action: "status",
        data: { status: status },
        confirmation: true,
    })
}
</script>
