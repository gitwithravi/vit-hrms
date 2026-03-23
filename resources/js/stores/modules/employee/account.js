import { mutations, actions, getters } from "@stores/globalNestedModule"

const initialState = () => ({
    initURL: "/app/employees",
    module: "/accounts",
    formErrors: {},
})

const account = {
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

export default account
