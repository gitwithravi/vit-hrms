<template>
    <PageHeader
        v-if="employee.uuid"
        :title="$trans(route.meta.label)"
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
        <PageHeaderAction :additional-actions="additionalActions" />
    </PageHeader>

    <ParentTransition appear :visibility="true">
        <BaseCard v-if="employee.uuid">
            <template v-if="!user">
                <BaseAlert design="error">
                    {{ $trans("contact.login.no_login_found") }}
                </BaseAlert>
            </template>

            <template v-else>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                    <BaseDataView :label="$trans('contact.login.props.email')">
                        {{ user.email }}
                    </BaseDataView>
                    <BaseDataView
                        :label="$trans('contact.login.props.username')"
                    >
                        {{ user.username }}
                    </BaseDataView>
                    <BaseDataView
                        :label="$trans('contact.login.props.password')"
                    >
                        xxxxxxxxx
                    </BaseDataView>
                    <BaseDataView :label="$trans('team.config.role.role')">
                        <div class="space-x-1">
                            <BaseBadge
                                design="primary"
                                v-for="role in user.roles"
                                >{{ role.label }}</BaseBadge
                            >
                        </div>
                    </BaseDataView>
                </dl>
            </template>
        </BaseCard>
    </ParentTransition>
</template>

<script>
export default {
    name: "EmployeeShowLogin",
}
</script>

<script setup>
import { inject, computed } from "vue"
import { useStore } from "vuex"
import { useRoute } from "vue-router"
import { perform } from "@core/helpers/action"

const route = useRoute()
const store = useStore()

const $trans = inject("$trans")

const props = defineProps({
    employee: {
        type: Object,
        default() {
            return {}
        },
    },
})

let additionalActions = []
if (perform("employee:edit")) {
    additionalActions.push({
        label: $trans("global.edit", {
            attribute: $trans("contact.login.login"),
        }),
        path: {
            name: "EmployeeEditLogin",
            params: { uuid: props.employee.uuid },
        },
    })
}

const user = computed(() => props.employee.contact.user)
</script>
