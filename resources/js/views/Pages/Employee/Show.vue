<template>
    <ModuleConfig :navigations="navigations" use-uuid>
        <template #header>
            <BaseLoader>
                <div class="mb-4" v-if="employee.uuid">
                    <img
                        class="h-32 w-full object-cover lg:h-48"
                        src="/images/user-cover.jpeg"
                        alt=""
                    />
                    <div class="-mt-12 flex w-full justify-center sm:-mt-16">
                        <img
                            class="h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32"
                            :src="employee.contact.photo"
                            alt=""
                        />
                    </div>

                    <div class="mt-4 text-center text-white">
                        <p>{{ employee.codeNumber }}</p>
                        <h1 class="font-bold">
                            {{ employee.contact.name }}
                        </h1>
                        <p>
                            {{ employee.lastRecord?.department?.name }}
                            {{ employee.lastRecord?.designation?.name }}
                        </p>
                        <p>
                            <i class="fas fa-mobile-alt"></i>
                            {{ employee.contact.contactNumber }}
                        </p>
                    </div>
                </div>
            </BaseLoader>
        </template>
        <router-view v-if="employee.uuid" :employee="employee" />
    </ModuleConfig>
</template>

<script>
export default {
    name: "EmployeeShow",
}
</script>

<script setup>
import { ref, reactive, inject, watch, onMounted, onBeforeUnmount } from "vue"
import { useRoute, useRouter } from "vue-router"
import { useStore } from "vuex"

const route = useRoute()
const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

const navigations = [
    {
        name: "EmployeeShowBasic",
        icon: "fas fa-chevron-right",
        label: "general.basic",
    },
    {
        name: "EmployeeShowContact",
        icon: "fas fa-chevron-right",
        label: "contact.contact",
    },
    {
        name: "EmployeeRecord",
        icon: "fas fa-chevron-right",
        label: "employee.record.record",
    },
    {
        name: "EmployeeWorkShift",
        icon: "fas fa-chevron-right",
        label: "employee.work_shift.work_shift",
    },
    {
        name: "EmployeeShowLogin",
        icon: "fas fa-chevron-right",
        label: "contact.login.login",
    },
    {
        name: "EmployeeQualification",
        icon: "fas fa-chevron-right",
        label: "employee.qualification.qualification",
    },
    {
        name: "EmployeeAccount",
        icon: "fas fa-chevron-right",
        label: "finance.account.account",
    },
    {
        name: "EmployeeDocument",
        icon: "fas fa-chevron-right",
        label: "employee.document.document",
    },
    {
        name: "EmployeeExperience",
        icon: "fas fa-chevron-right",
        label: "employee.experience.experience",
    },
]

const isLoading = ref(false)

const employee = reactive({
    contact: {},
})

const records = reactive([])

const getEmployee = async () => {
    isLoading.value = true
    await store
        .dispatch("employee/get", {
            uuid: route.params.uuid,
        })
        .then((response) => {
            Object.assign(employee, response)
            isLoading.value = false
        })
        .catch((e) => {
            isLoading.value = false
            router.push({ name: "EmployeeList" })
        })
}

watch(
    () => route.params.uuid,
    (value, oldValue) => {
        if (value != undefined && value != oldValue) {
            getEmployee()
        }
    },
    { deep: true }
)

onMounted(async () => {
    emitter.on("employeeUpdated", () => {
        getEmployee()
    })

    await getEmployee()
})

onBeforeUnmount(() => {
    emitter.all.delete("employeeUpdated")
})
</script>
