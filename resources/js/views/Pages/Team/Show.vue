<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[{ label: $trans('team.team'), path: 'TeamList' }]"
    >
        <PageHeaderAction
            name="Team"
            :title="$trans('team.team')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'Team' })"
        >
            <BaseCard v-if="team.uuid">
                <template #title>
                    {{ team.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView :label="$trans('general.created_at')">
                        {{ team.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ team.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            design="primary"
                            @click="
                                router.push({
                                    name: 'TeamEdit',
                                    params: { uuid: team.uuid },
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
    name: "TeamShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialTeam = {}

const initUrl = "team/"

const team = reactive({ ...initialTeam })

const setItem = (data) => {
    Object.assign(team, data)
}
</script>
