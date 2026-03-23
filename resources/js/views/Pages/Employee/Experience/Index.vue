<template>
    <ListItem
        :init-url="initUrl"
        :uuid="route.params.uuid"
        @setItems="setItems"
    >
        <template #header>
            <PageHeader
                v-if="employee.uuid"
                :title="$trans('employee.experience.experience')"
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
                    :url="`employees/${employee.uuid}/experiences/`"
                    name="EmployeeExperience"
                    :title="$trans('employee.experience.experience')"
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
                :header="experiences.headers"
                :meta="experiences.meta"
                module="employee.experience"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="experience in experiences.data"
                    :key="experience.uuid"
                >
                    <DataCell name="headline">
                        {{ experience.headline }}
                    </DataCell>
                    <DataCell name="location">
                        {{ experience.location }}
                    </DataCell>
                    <DataCell name="employmentType">
                        {{ experience.employmentType.name }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ experience.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ experience.endDate.formatted }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ experience.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'EmployeeExperienceShow',
                                        params: {
                                            uuid: employee.uuid,
                                            muuid: experience.uuid,
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
                                            name: 'EmployeeExperienceEdit',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: experience.uuid,
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
                                            name: 'EmployeeExperienceDuplicate',
                                            params: {
                                                uuid: employee.uuid,
                                                muuid: experience.uuid,
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
                                            moduleUuid: experience.uuid,
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
                            router.push({ name: 'EmployeeExperienceCreate' })
                        "
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans(
                                    "employee.experience.experience"
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
    name: "EmployeeExperienceList",
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

const initUrl = "employee/experience/"
const showFilter = ref(false)

const experiences = reactive({})

const setItems = (data) => {
    Object.assign(experiences, data)
}
</script>
