import { mutations, actions, getters } from "@stores/globalNestedModule"

const initialState = () => ({
    initURL: "/app/employees",
    module: "/documents",
    formErrors: {},
})

const document = {
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

export default document
