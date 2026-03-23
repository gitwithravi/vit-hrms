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
            name="EmployeeDocument"
            :title="$trans('employee.document.document')"
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
                    name: 'EmployeeDocument',
                    params: { uuid: employee.uuid },
                })
            "
        >
            <BaseCard v-if="document.uuid">
                <template #title>
                    {{ document.type.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('employee.document.props.title')"
                    >
                        {{ document.title }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('employee.document.props.description')"
                    >
                        {{ document.description }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.document.props.start_date')"
                    >
                        {{ document.startDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('employee.document.props.end_date')"
                    >
                        {{ document.endDate.formatted }}
                    </BaseDataView>

                    <BaseDataView class="col-span-1 sm:col-span-2">
                        <ListMedia
                            :media="document.media"
                            :url="`/app/employees/${employee.uuid}/documents/${document.uuid}/`"
                        />
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ document.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ document.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('employee:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'EmployeeDocumentEdit',
                                    params: {
                                        uuid: employee.uuid,
                                        muuid: document.uuid,
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
    name: "EmployeeDocumentShow",
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

const initialDocument = {}

const initUrl = "employee/document/"

const document = reactive({ ...initialDocument })

const setItem = (data) => {
    Object.assign(document, data)
}
</script>
