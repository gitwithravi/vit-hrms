<template>
    <ListItem :init-url="initUrl" @setItems="setItems">
        <template #header>
            <PageHeader
                :title="$trans('calendar.holiday.holiday')"
                :navs="[
                    { label: $trans('calendar.calendar'), path: 'Calendar' },
                ]"
            >
                <PageHeaderAction
                    url="calendar/holidays/"
                    name="CalendarHoliday"
                    :title="$trans('calendar.holiday.holiday')"
                    :actions="userActions"
                    :dropdown-actions="dropdownActions"
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
                :header="holidays.headers"
                :meta="holidays.meta"
                module="calendar.holiday"
                @refresh="emitter.emit('listItems')"
            >
                <DataRow v-for="holiday in holidays.data" :key="holiday.uuid">
                    <DataCell name="name">
                        {{ holiday.name }}
                    </DataCell>
                    <DataCell name="startDate">
                        {{ holiday.startDate.formatted }}
                    </DataCell>
                    <DataCell name="endDate">
                        {{ holiday.endDate.formatted }}
                    </DataCell>
                    <DataCell name="duration">
                        {{ holiday.duration }}
                    </DataCell>
                    <DataCell name="createdAt">
                        {{ holiday.createdAt.formatted }}
                    </DataCell>
                    <DataCell name="action">
                        <FloatingMenu>
                            <FloatingMenuItem
                                icon="fas fa-arrow-circle-right"
                                @click="
                                    router.push({
                                        name: 'CalendarHolidayShow',
                                        params: { uuid: holiday.uuid },
                                    })
                                "
                                >{{ $trans("general.show") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('holiday:edit')"
                                icon="fas fa-edit"
                                @click="
                                    router.push({
                                        name: 'CalendarHolidayEdit',
                                        params: { uuid: holiday.uuid },
                                    })
                                "
                                >{{ $trans("general.edit") }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('holiday:create')"
                                icon="fas fa-copy"
                                @click="
                                    router.push({
                                        name: 'CalendarHolidayDuplicate',
                                        params: { uuid: holiday.uuid },
                                    })
                                "
                                >{{
                                    $trans("general.duplicate")
                                }}</FloatingMenuItem
                            >
                            <FloatingMenuItem
                                v-if="perform('holiday:delete')"
                                icon="fas fa-trash"
                                @click="
                                    emitter.emit('deleteItem', {
                                        uuid: holiday.uuid,
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
                        v-if="perform('holiday:create')"
                        @click="router.push({ name: 'CalendarHolidayCreate' })"
                    >
                        {{
                            $trans("global.add", {
                                attribute: $trans("calendar.holiday.holiday"),
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
    name: "CalendarHolidayList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"

const router = useRouter()

const emitter = inject("emitter")

let userActions = ["filter"]
if (perform("holiday:create")) {
    userActions.unshift("create")
}

let dropdownActions = []
if (perform("holiday:export")) {
    dropdownActions = ["print", "pdf", "excel"]
}

const initUrl = "calendar/holiday/"
const showFilter = ref(false)

const holidays = reactive({})

const setItems = (data) => {
    Object.assign(holidays, data)
}
</script>
