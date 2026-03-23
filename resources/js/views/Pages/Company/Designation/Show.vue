<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('company.company'), path: 'Company' },
            {
                label: $trans('company.designation.designation'),
                path: 'CompanyDesignationList',
            },
        ]"
    >
        <PageHeaderAction
            name="CompanyDesignation"
            :title="$trans('company.designation.designation')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'CompanyDesignation' })"
        >
            <BaseCard v-if="designation.uuid">
                <template #title>
                    {{ designation.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('company.designation.props.name')"
                    >
                        {{ designation.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('company.designation.props.alias')"
                    >
                        {{ designation.alias }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('company.designation.props.parent')"
                    >
                        {{ designation.parent ? designation.parent.name : "-" }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('company.designation.props.description')"
                    >
                        <div v-html="designation.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ designation.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ designation.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('designation:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'CompanyDesignationEdit',
                                    params: { uuid: designation.uuid },
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
    name: "CompanyDesignationShow",
}
</script>

<script setup>
import { reactive, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { perform } from "@core/helpers/action"

const store = useStore()
const route = useRoute()
const router = useRouter()

const initialDesignation = {}

const initUrl = "company/designation/"

const designation = reactive({ ...initialDesignation })

const setItem = (data) => {
    Object.assign(designation, data)
}
</script>
