import { mutations, actions, getters } from "@stores/globalNestedModule"

const initialState = () => ({
    initURL: "/app/employees",
    module: "/records",
    formErrors: {},
})

const record = {
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

export default record
