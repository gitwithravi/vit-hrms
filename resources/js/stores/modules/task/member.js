import { mutations, actions, getters } from "@stores/globalNestedModule"

const initialState = () => ({
    initURL: "/app/tasks",
    module: "/members",
    formErrors: {},
})

const member = {
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

export default member
