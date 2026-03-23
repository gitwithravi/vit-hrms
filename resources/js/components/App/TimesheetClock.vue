<template>
    <span
        class="isolate inline-flex rounded-md shadow-sm"
        v-if="allowEmployeeClockInOut && state.hasTimesheet"
    >
        <!-- <span class="text-white">{{ isProcessing }}</span> -->
        <button
            type="button"
            :disabled="isProcessing"
            @click="clock"
            class="relative inline-flex items-center border px-4 py-2 text-sm font-medium"
            :class="{
                'bg-info border-info text-secondary hover:bg-dark-info':
                    state.timesheet?.clockIn,
                'bg-danger border-danger text-secondary hover:bg-dark-danger':
                    state.timesheet?.clockOut,
                'rounded-l-md': state.timesheets.length,
                'rounded-md': state.timesheets.length === 0,
            }"
        >
            <div class="space-x-2">
                <span v-if="isProcessing">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
                <span v-if="enableGeolocationTimesheet">
                    <i class="fas fa-location-dot"></i>
                </span>
                {{
                    state.timesheet?.clockIn
                        ? $trans("attendance.timesheet.props.clock_in")
                        : $trans("attendance.timesheet.props.clock_out")
                }}
            </div>
        </button>
        <VDropdown
            v-if="state.timesheets.length"
            :distance="6"
            placement="bottom-end"
        >
            <button
                type="button"
                class="relative -ml-px inline-flex items-center rounded-r-md border px-3 py-2 text-sm font-medium"
                :class="{
                    'bg-info border-light-info text-secondary hover:bg-dark-info':
                        state.timesheet?.clockIn,
                    'bg-danger border-light-danger text-secondary hover:bg-dark-danger':
                        state.timesheet?.clockOut,
                }"
            >
                {{ state.timesheets.length }}
            </button>
            <template #popper>
                <div
                    class="dark:bg-dark-body w-64 divide-y divide-gray-200 text-sm dark:divide-gray-700 dark:text-gray-300"
                >
                    <div
                        v-for="timesheet in state.timesheets"
                        class="flex justify-between px-4 py-2"
                    >
                        <div class="text-success">
                            <i
                                class="fas fa-circle-arrow-down text-green-400"
                            ></i>
                            {{ timesheet.inAtTime.formatted }}
                            <span class="ml-2 text-xs text-gray-400">{{
                                timesheet.duration
                            }}</span>
                        </div>
                        <div class="text-danger" v-if="timesheet.outAt">
                            {{ timesheet.outAtTime.formatted }}
                            <i class="fas fa-circle-arrow-up text-red-400"></i>
                        </div>
                    </div>
                </div>
            </template>
        </VDropdown>
    </span>
</template>

<script setup>
import { reactive, ref, computed, inject, onMounted } from "vue"
import { useStore } from "vuex"
import { getConfig } from "@core/helpers/action"
import { showError } from "@core/helpers/alert"

const store = useStore()

const $trans = inject("$trans")

const allowEmployeeClockInOut = computed(
    () => getConfig("attendance.allowEmployeeClockInOut").value
)

const enableGeolocationTimesheet = computed(
    () => getConfig("attendance.enableGeolocationTimesheet").value
)

const isProcessing = ref(false)

const state = reactive({
    hasTimesheet: false,
    timesheet: {},
    timesheets: [],
})

const checkTimesheet = async () => {
    if (!allowEmployeeClockInOut.value) {
        return
    }

    await store
        .dispatch("attendance/timesheet/check")
        .then((response) => {
            if (response.hasTimesheet) {
                state.hasTimesheet = true
                state.timesheet = response.timesheet
                state.timesheets = response.timesheets || 0
            }
        })
        .catch((e) => {})
}

const clock = async () => {
    isProcessing.value = true

    if (!enableGeolocationTimesheet.value) {
        await storeTimesheet()
        isProcessing.value = false
        return
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            handleLocationSuccess,
            handleLocationError
        )
    } else {
        showError($trans("timesheet.geolocation_not_supported"))
        isProcessing.value = false
    }
}

const storeTimesheet = async (location = {}) => {
    await store
        .dispatch("attendance/timesheet/clock", {
            type: state.timesheet?.clockIn ? "in" : "out",
            location,
        })
        .then((response) => {
            state.timesheet = response.timesheet
            state.timesheets = response.timesheets || 0
            isProcessing.value = false
        })
        .catch((e) => {
            isProcessing.value = false
        })
}

const handleLocationSuccess = async (position) => {
    const latitude = position.coords.latitude
    const longitude = position.coords.longitude

    await storeTimesheet({ latitude, longitude })
}

const handleLocationError = (error) => {
    showError($trans("attendance.timesheet.unable_to_detect_geolocation"))
    isProcessing.value = false
}

onMounted(async () => {
    await checkTimesheet()
})
</script>
