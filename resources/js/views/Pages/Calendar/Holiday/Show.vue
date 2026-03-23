<template>
    <PageHeader
        :title="
            $trans(route.meta.trans, {
                attribute: $trans(route.meta.label),
            })
        "
        :navs="[
            { label: $trans('calendar.calendar'), path: 'Calendar' },
            {
                label: $trans('calendar.holiday.holiday'),
                path: 'CalendarHolidayList',
            },
        ]"
    >
        <PageHeaderAction
            name="CalendarHoliday"
            :title="$trans('calendar.holiday.holiday')"
            :actions="['list']"
        />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <ShowItem
            :init-url="initUrl"
            :uuid="route.params.uuid"
            @setItem="setItem"
            @redirectTo="router.push({ name: 'Holiday' })"
        >
            <BaseCard v-if="holiday.uuid">
                <template #title>
                    {{ holiday.name }}
                </template>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <BaseDataView
                        :label="$trans('calendar.holiday.props.name')"
                    >
                        {{ holiday.name }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('calendar.holiday.props.start_date')"
                    >
                        {{ holiday.startDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        :label="$trans('calendar.holiday.props.end_date')"
                    >
                        {{ holiday.endDate.formatted }}
                    </BaseDataView>

                    <BaseDataView
                        class="col-span-1 sm:col-span-2"
                        :label="$trans('calendar.holiday.props.description')"
                    >
                        <div v-html="holiday.description"></div>
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.created_at')">
                        {{ holiday.createdAt.formatted }}
                    </BaseDataView>

                    <BaseDataView :label="$trans('general.updated_at')">
                        {{ holiday.updatedAt.formatted }}
                    </BaseDataView>
                </dl>
                <template #footer>
                    <ShowButton>
                        <BaseButton
                            v-if="perform('holiday:edit')"
                            design="primary"
                            @click="
                                router.push({
                                    name: 'CalendarHolidayEdit',
                                    params: { uuid: holiday.uuid },
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
    name: "CalendarHolidayShow",
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

const initialHoliday = {}

const initUrl = "calendar/holiday/"

const holiday = reactive({ ...initialHoliday })

const setItem = (data) => {
    Object.assign(holiday, data)
}
</script>
