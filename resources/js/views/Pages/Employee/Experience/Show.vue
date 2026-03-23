<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('employee.employee'), path: 'Employee' },
            {
                label: employee.contact.name,
                path: {
                    name: 'EmployeeShow',
                    params: { uuid: employee.uuid },
                },
            },
        ]"
    >
        <PageHeaderAction
            name="EmployeeExperience"
            :title="$trans('employee.experience.experience')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            :module-uuid="route.params.muuid"
            @setItem="setItem"
            @redirectTo="
                router.push({
                    name: 'EmployeeExperience',
                    params: { uuid: employee.uuid },
                })
            "
        >
            <BaseCard v-if="experience.uuid">
                <template #title>
                    {{ experience.headline }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="
                            $trans('employee.employment_type.employment_type')
                        "
                    >
                        {{ experience.employmentType.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.experience.props.title')"
                    >
                        {{ experience.title }}
                    </BaseDataView>

                    <BaseDataView
                        :label="
                            $trans(
                                'employee.experience.props.organization_name'
                            )
                        "
                    >
                        {{ experience.organizationName }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.experience.props.location')"
                    >
                        {{ experience.location }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.experience.props.start_date')"
                    >
                        {{ experience.startDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.experience.props.end_date')"
                    >
                        {{ experience.endDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('employee.experience.props.job_profile')"
                    >
                        {{ experience.jobProfile }}
                    </BaseDataView>

                    <BaseDataView class="col-span-1 sm:col-span-2">
                        <ListMedia
                            :media="experience.media"
                            :url="`/app/employees/${employee.uuid}/experiences/${experience.uuid}/`"
                        />
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ experience.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ experience.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('employee:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'EmployeeExperienceEdit',
                                    params: {
                                        uuid: employee.uuid,
                                        muuid: experience.uuid,
                                    },
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
    name: "EmployeeExperienceShow",
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

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initialExperience = {}

const initUrl = "employee/experience/"

const experience = reactive({ ...initialExperience })

const setItem = (data) => {
    Object.assign(experience, data)
}
</script>
