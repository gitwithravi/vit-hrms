<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('attendance.type.type')"
                :navs="[
                    {
                        label: $trans('attendance.attendance'),
                        path: 'Attendance',
                    },
                ]"
            >
                <PageHeaderAction
                    url="attendance/types/"
                    name="AttendanceType"
                    :title="$trans('attendance.type.type')"
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
                :header="attendanceTypes.headers"
                :meta="attendanceTypes.meta"
                module="attendance.type"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow
                    v-for="attendanceType in attendanceTypes.data"
                    :key="attendanceType.uuid"
                >
                    <DataCell name="name">
                        {{ attendanceType.name }}
                    </DataCell>
                    <DataCell name="code">
                        {{ attendanceType.code }}
                    </DataCell>
                    <DataCell name="category">
                        {{ attendanceType.category.label }}
                        <span v-if="attendanceType.unit.value"
                            >({{ attendanceType.unit.label }})</span
                        >
                    </DataCell>
                    <DataCell name="alias">
                        {{ attendanceType.alias }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ attendanceType.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'AttendanceTypeShow',
                                        params: { uuid: attendanceType.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'AttendanceTypeEdit',
                                        params: { uuid: attendanceType.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'AttendanceTypeDuplicate',
                                        params: { uuid: attendanceType.uuid },
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
                                        uuid: attendanceType.uuid,
                                    })
                                "
                                >{{
                                    $trans("general.delete")
                                }}</FloatingMenuItem
                            >
                        </FloatingMenu>
                    </DataCell>
                </DataRow>
                <template #actionButton>
                    <BaseButton
                        @click="router.push({ name: 'AttendanceTypeCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("attendance.type.type"),
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
    name: "AttendanceTypeList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["create", "filter"]

const initUrl = "attendance/type/"
const showFilter = ref(false)

const attendanceTypes = reactive({})

const setItems = (data) => {
    Object.assign(attendanceTypes, data)
}
</script>
