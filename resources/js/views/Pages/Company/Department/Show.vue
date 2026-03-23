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
                label: $trans('company.department.department'),
                path: 'CompanyDepartmentList',
            },
        ]"
    >
        <PageHeaderAction
            name="CompanyDepartment"
            :title="$trans('company.department.department')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'CompanyDepartment' })"
        >
            <BaseCard v-if="department.uuid">
                <template #title>
                    {{ department.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('company.department.props.name')"
                    >
                        {{ department.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('company.department.props.alias')"
                    >
                        {{ department.alias }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('company.department.props.description')"
                    >
                        <div v-html="department.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ department.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ department.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('department:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'CompanyDepartmentEdit',
                                    params: { uuid: department.uuid },
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
    name: "CompanyDepartmentShow",
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

const initialDepartment = {}

const initUrl = "company/department/"

const department = reactive({ ...initialDepartment })

const setItem = (data) => {
    Object.assign(department, data)
}
</script>
