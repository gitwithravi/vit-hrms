import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/payroll/salary-structures",
    formErrors: {},
})

const salaryStructure = {
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

export default salaryStructure
