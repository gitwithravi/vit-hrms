<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="employee.uuid"
                :title="$trans('employee.qualification.qualification')"
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
                    :url="`employees/${employee.uuid}/qualifications/`"
                    name="EmployeeQualification"
                    :title="$trans('employee.qualification.qualification')"
                    :actions="userActions"
                    :dropdown-actions="['print', 'pdf', 'excel']"
                    @toggleFilter="showFilter = !showFilter"
                />
            </PageHeader>
        </template>

        <template #filter>
            <ParentTransition appear :visibility="showFilter">
                <FilterForm
                    @refresh="emitter.emit('listItems')"
                    @hide="showFilter = false"
                ></FilterForm>
            </ParentTransition>
        </template>

        <ParentTransition appear :visibility="true">
            <DataTable
                :header="qualifications.headers"
                :meta="qualifications.meta"
                module="employee.qualification"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="qualification in qualifications.data"
                    :key="qualification.uuid"
                >
                    <DataCell name="course">
                        {{ qualification.course }}
                    </DataCell>
                    <DataCell name="institute">
                        {{ qualification.institute }}
                    </DataCell>
                    <DataCell name="level">
                        {{ qualification.level.name }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ qualification.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ qualification.endDate.formatted }}
                    </DataCell>
                    <DataCell name="result">
                        {{ qualification.result }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ qualification.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeQualificationShow',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: qualification.uuid,
                                        },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <template v-if="perform('employee:edit')">
                                <FloatingMenuItem
                                    icon="fas fa-edit"
                                    @click="
                                        router.push({
                                            name: 'EmployeeQualificationEdit',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: qualification.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.edit")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-copy"
                                    @click="
                                        router.push({
                                            name: 'EmployeeQualificationDuplicate',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: qualification.uuid,
                                            },
                                        })
                                    "
                                    >{{
                                        $trans("general.duplicate")
                                    }}</FloatingMenuItem
                                >
                                <FloatingMenuItem
                                    icon="fas fa-trash"
                                    @click="
                                        emitter.emit('deleteItem', {
                                            uuid: employee.uuid,
                                            moduleUuid: qualification.uuid,
                                        })
                                    "
                                    >{{
                                        $trans("general.delete")
                                    }}</FloatingMenuItem
                                >
                            </template>
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        v-if="perform('employee:edit')"
                        @click="
                            router.push({ name: 'EmployeeQualificationCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "employee.qualification.qualification"
                                ),
                            })
                        }}
                    </BaseButton>
                </template>
            </DataTable>
        </ParentTransition>
    </ListItem>
</template>

<script>
export default {
    name: "EmployeeQualificationList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const route = useRoute()
const router = useRouter()

const emitter = inject("emitter")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

let userActions = ["filter"]
if (perform("employee:edit")) {
    userActions.unshift("create")
}

const initUrl = "employee/qualification/"
const showFilter = ref(false)

const qualifications = reactive({})

const setItems = (data) => {
    Object.assign(qualifications, data)
}
</script>
