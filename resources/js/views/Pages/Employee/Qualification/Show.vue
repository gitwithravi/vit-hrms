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
            name="EmployeeQualification"
            :title="$trans('employee.qualification.qualification')"
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
                    name: 'EmployeeQualification',
                    params: { uuid: employee.uuid },
                })
            "
        >
            <BaseCard v-if="qualification.uuid">
                <template #title>
                    {{ qualification.level.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('employee.qualification.props.course')"
                    >
                        {{ qualification.course }}
                    </BaseDataView>

                    <BaseDataView
                        :label="
                            $trans('employee.qualification.props.institute')
                        "
                    >
                        {{ qualification.institute }}
                    </BaseDataView>

                    <BaseDataView
                        :label="
                            $trans('employee.qualification.props.affiliated_to')
                        "
                    >
                        {{ qualification.affiliatedTo }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.qualification.props.result')"
                    >
                        {{ qualification.result }}
                    </BaseDataView>

                    <BaseDataView
                        :label="
                            $trans('employee.qualification.props.start_date')
                        "
                    >
                        {{ qualification.startDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.qualification.props.end_date')"
                    >
                        {{ qualification.endDate.formatted }}
                    </BaseDataView>

                    <BaseDataView class="col-span-1 sm:col-span-2">
                        <ListMedia
                            :media="qualification.media"
                            :url="`/app/employees/${employee.uuid}/qualifications/${qualification.uuid}/`"
                        />
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ qualification.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ qualification.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('employee:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'EmployeeQualificationEdit',
                                    params: {
                                        uuid: employee.uuid,
                                        muuid: qualification.uuid,
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
    name: "EmployeeQualificationShow",
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

const initialQualification = {}

const initUrl = "employee/qualification/"

const qualification = reactive({ ...initialQualification })

const setItem = (data) => {
    Object.assign(qualification, data)
}
</script>
