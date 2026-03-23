import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/company/branches",
    formErrors: {},
})

const branch = {
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

export default branch
