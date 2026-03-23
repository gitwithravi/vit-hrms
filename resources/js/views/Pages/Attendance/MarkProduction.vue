<template>
    <PageHeader
        :title="$trans(route.meta.label)"
        :navs="[
            { label: $trans('attendance.attendance'), path: 'Attendance' },
            { label: $trans('attendance.mark'), path: 'AttendanceMark' },
        ]"
    >
        <PageHeaderAction>
            <BaseButton
                design="white"
                @click="router.push({ name: 'AttendanceList' })"
            >
                {{
                    $trans("global.list", {
                        attribute: $trans("attendance.attendance"),
                    })
                }}
            </BaseButton>
        </PageHeaderAction>
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <FilterForm
            @afterFilter="fetchProduction"
            :init-url="initUrl"
        ></FilterForm>
    </ParentTransition>

    <BaseCard
        no-padding
        no-content-padding
        :is-loading="isLoading"
        v-if="form.records.length"
    >
        <template #title>
            {{ $trans("attendance.mark_production") }}
        </template>

        <FormAction
            no-card
            button-padding
            :keep-adding="false"
            :stay-on="true"
            :init-url="initUrl"
            action="markProduction"
            :init-form="initForm"
            :form="form"
        >
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <div
                    class="grid grid-cols-3 gap-6 px-4 py-2"
                    v-for="(record, index) in form.records"
                    :key="record.attendanceType.uuid"
                >
                    <div class="col-span-3 sm:col-span-1">
                        <BaseDataView
                            :label="
                                record.attendanceType.name +
                                ' (' +
                                record.attendanceType.code +
                                ')'
                            "
                            revert
                        >
                            {{ record.attendanceType.categoryDisplay }} ({{
                                record.attendanceType.unitDisplay
                            }})
                        </BaseDataView>
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseInput
                            type="text"
                            v-model="record.value"
                            :name="`records.${index}.value`"
                            :placeholder="$trans('attendance.props.value')"
                            v-model:error="formErrors[`records.${index}.value`]"
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <BaseTextarea
                            :rows="1"
                            v-model="record.remarks"
                            :name="`records.${index}.remarks`"
                            :placeholder="$trans('attendance.props.remarks')"
                            v-model:error="
                                formErrors[`records.${index}.remarks`]
                            "
                        />
                    </div>
                </div>
            </div>
        </FormAction>
    </BaseCard>
</template>

<script>
export default {
    name: "AttendanceMark",
}
</script>

<script setup>
import { ref, reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"
import FilterForm from "./FilterProduction.vue"

const route = useRoute()
const router = useRouter()
const store = useStore()

const initForm = {
    records: [],
}

const initUrl = "attendance/"
const isLoading = ref(false)

const formErrors = getFormErrors(initUrl)
const form = reactive({ ...initForm })

const fetchProduction = async () => {
    form.records = []
    isLoading.value = true
    await store
        .dispatch(initUrl + "fetchProduction", {
            params: route.query,
        })
        .then((response) => {
            isLoading.value = false
            form.records = response
        })
        .catch((e) => {
            isLoading.value = false
        })
}

const resetForm = () => {
    Object.assign(form, cloneDeep(initForm))
}

onMounted(async () => {
    if (route.query.employee && route.query.date) {
        await fetchProduction()
    }
})
</script>
