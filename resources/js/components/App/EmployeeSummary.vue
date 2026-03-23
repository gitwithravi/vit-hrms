<template>
    <div class="relative rounded-lg cursor-pointer dark:bg-dark-header bg-white flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 overflow-hidden" @click="router.push({name: 'EmployeeShow', params: {uuid: employee.uuid}})">
        <div class="flex-shrink-0" v-if="employee.photo">
            <img class="h-16 w-16 rounded-full" :src="employee.photo" alt="" />
        </div>
        <div class="flex-1 min-w-0">
            <div class="focus:outline-none space-y-1">
                <span class="absolute inset-0" aria-hidden="true" />
                <p class="text-sm font-medium text-gray-900 dark:text-gray-400">
                    {{ employee.name }} <span class="">({{ employee.codeNumber }})</span>
                </p>
                <p class="text-sm text-gray-500 truncate">
                    {{ employee.designation }} @ {{ employee.branch }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EmployeeSummary'
}
</script>

<script setup>
import { useRouter } from "vue-router"

const router = useRouter()

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        }
    }
})
</script>
