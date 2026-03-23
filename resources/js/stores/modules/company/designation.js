import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/company/designations",
    formErrors: {},
})

const designation = {
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

export default designation
