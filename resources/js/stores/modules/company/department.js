import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/company/departments",
    formErrors: {},
})

const department = {
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

export default department
