<template>
    <BaseCard :is-loading="isLoading">
        <template #title>{{
            $trans("config.system.props.setup_wizard")
        }}</template>
        <template #action>
            <i
                class="fas fa-times fa-lg text-gray-500 cursor-pointer"
                @click="hideSetupWizard"
            ></i>
        </template>
        <div class="space-y-2">
            <BaseAlert v-if="state.steps.length == 0" size="xs" design="info">
                {{ $trans("config.system.setup_wizard_not_available") }}
            </BaseAlert>

            <p
                class="text-sm text-gray-800 dark:text-gray-400"
                v-if="state.header"
            >
                {{ state.header }}
            </p>

            <nav aria-label="Progress">
                <ol role="list" class="mt-4 overflow-hidden">
                    <li
                        v-for="(step, stepIdx) in state.steps"
                        :key="step.name"
                        :class="[
                            stepIdx !== state.steps.length - 1 ? 'pb-10' : '',
                            'relative',
                        ]"
                    >
                        <template v-if="step.isCompleted">
                            <div
                                v-if="stepIdx !== state.steps.length - 1"
                                class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-primary dark:bg-dark-body"
                                aria-hidden="true"
                            />
                            <span
                                @click="setActiveStep(step)"
                                class="group relative flex items-center cursor-pointer"
                            >
                                <span class="flex h-9 items-center">
                                    <span
                                        class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-primary dark:bg-dark-body group-hover:bg-primary dark:group-hover:bg-dark-body"
                                    >
                                        <i class="fas fa-check text-white"></i>
                                    </span>
                                </span>
                                <span class="ml-4 flex min-w-0 flex-col">
                                    <span
                                        class="text-sm font-medium dark:text-gray-400"
                                        >{{ step.title }}</span
                                    >
                                    <template
                                        v-if="step.name == activeStep?.name"
                                    >
                                        <span
                                            class="text-sm font-medium"
                                            v-if="step.summary"
                                            >{{ step.summary }}</span
                                        >
                                        <span class="text-sm text-gray-500">{{
                                            step.description
                                        }}</span>

                                        <div class="mt-2 flex justify-end">
                                            <BaseButton
                                                size="xs"
                                                @click="
                                                    router.push({
                                                        name: step.route,
                                                    })
                                                "
                                                >{{
                                                    $trans("general.proceed")
                                                }}</BaseButton
                                            >
                                        </div>
                                    </template>
                                </span>
                            </span>
                        </template>
                        <template v-else-if="step.name == activeStep?.name">
                            <div
                                v-if="stepIdx !== state.steps.length - 1"
                                class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300"
                                aria-hidden="true"
                            />
                            <span
                                @click="setActiveStep(step)"
                                class="cursor-pointer group relative flex items-start"
                                aria-current="step"
                            >
                                <span
                                    class="flex h-9 items-center"
                                    aria-hidden="true"
                                >
                                    <span
                                        class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-primary dark:border-dark-body bg-white"
                                    >
                                        <span
                                            class="h-2.5 w-2.5 rounded-full bg-primary"
                                        />
                                    </span>
                                </span>
                                <span class="ml-4 flex min-w-0 flex-col">
                                    <span
                                        class="text-sm font-medium text-gray-800 dark:text-gray-200"
                                        >{{ step.title }}</span
                                    >
                                    <template
                                        v-if="step.name == activeStep?.name"
                                    >
                                        <span
                                            class="text-sm font-medium"
                                            v-if="step.summary"
                                            >{{ step.summary }}</span
                                        >
                                        <span class="text-sm text-gray-500">{{
                                            step.description
                                        }}</span>

                                        <div class="mt-2 flex justify-end">
                                            <BaseButton
                                                size="xs"
                                                @click="
                                                    router.push({
                                                        name: step.route,
                                                    })
                                                "
                                                >{{
                                                    $trans("general.proceed")
                                                }}</BaseButton
                                            >
                                        </div>
                                    </template>
                                </span>
                            </span>
                        </template>
                        <template v-else>
                            <div
                                v-if="stepIdx !== state.steps.length - 1"
                                class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300"
                                aria-hidden="true"
                            />
                            <span
                                @click="setActiveStep(step)"
                                class="cursor-pointer group relative flex items-center"
                            >
                                <span
                                    class="flex h-9 items-center"
                                    aria-hidden="true"
                                >
                                    <span
                                        class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400"
                                    >
                                        <span
                                            class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"
                                        />
                                    </span>
                                </span>
                                <span class="ml-4 flex min-w-0 flex-col">
                                    <span
                                        class="text-sm font-medium text-gray-500"
                                        >{{ step.title }}</span
                                    >
                                    <template
                                        v-if="step.name == activeStep?.name"
                                    >
                                        <span
                                            class="text-sm font-medium"
                                            v-if="step.summary"
                                            >{{ step.summary }}</span
                                        >
                                        <span class="text-sm text-gray-500">{{
                                            step.description
                                        }}</span>
                                        <div class="mt-2 flex justify-end">
                                            <BaseButton
                                                size="xs"
                                                @click="
                                                    router.push({
                                                        name: step.route,
                                                    })
                                                "
                                                >{{
                                                    $trans("general.proceed")
                                                }}</BaseButton
                                            >
                                        </div>
                                    </template>
                                </span>
                            </span>
                        </template>
                    </li>
                </ol>
            </nav>

            <div v-if="hasStepsCompleted">
                <p
                    class="mt-4 text-sm text-gray-800 dark:text-gray-400"
                    v-if="state.completed"
                >
                    {{ state.completed }}
                </p>
                <BaseButton
                    block
                    size="sm"
                    @click="hideSetupWizard"
                    class="mt-2"
                >
                    {{
                        $trans("global.hide", {
                            attribute: $trans(
                                "config.system.props.setup_wizard"
                            ),
                        })
                    }}
                </BaseButton>
            </div>
            <div v-else>
                <p
                    class="mt-4 text-sm text-gray-800 dark:text-gray-400"
                    v-if="state.footer"
                >
                    {{ state.footer }}
                </p>
            </div>
        </div>
    </BaseCard>
</template>

<script>
export default {
    name: "SetupWizard",
}
</script>

<script setup>
import {
    ref,
    reactive,
    inject,
    computed,
    onMounted,
    onBeforeUnmount,
} from "vue"
import { useRouter } from "vue-router"
import { useStore } from "vuex"
import { getAuthUser } from "@core/helpers/action"
import { ChevronUpIcon } from "@heroicons/vue/20/solid"

const router = useRouter()
const store = useStore()

const emitter = inject("emitter")

const user = getAuthUser("profile.name")

const hasStepsCompleted = computed(() => {
    return state.steps.every((step) => step.isCompleted)
})

const activeStep = ref(null)
const isLoading = ref(false)

const state = reactive({
    header: "",
    footer: "",
    completed: "",
    steps: [],
})

const isActiveState = (step) => {
    return step.name === activeStep.value.name
}

const setActiveStep = (step) => {
    activeStep.value = step
}

const getData = async () => {
    isLoading.value = true
    await store
        .dispatch("setup/wizard/getSteps")
        .then((response) => {
            isLoading.value = false
            Object.assign(state, response)
            activeStep.value = state.steps.find((step) => !step.isCompleted)
        })
        .catch((e) => {
            isLoading.value = false
        })
}

const hideSetupWizard = async () => {
    await store
        .dispatch("config/store", {
            form: {
                type: "system",
                showSetupWizard: false,
            },
        })
        .then((response) => {
            store.dispatch("config/get")
            router.push({ name: "Dashboard" })
        })
        .catch((e) => {
            //
        })
}

onMounted(async () => {
    await getData()

    emitter.on("refreshSetupWizard", () => {
        getData()
    })
})

onBeforeUnmount(() => {
    emitter.all.delete("refreshSetupWizard")
})
</script>
