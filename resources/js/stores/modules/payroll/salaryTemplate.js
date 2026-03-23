import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/payroll/salary-templates",
    formErrors: {},
})

const salaryTemplate = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
    },
    getters: {
        ...getters,
    },
}

export default salaryTemplate
