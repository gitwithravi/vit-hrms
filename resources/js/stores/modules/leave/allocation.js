import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/leave/allocations",
    formErrors: {},
})

const allocation = {
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

export default allocation
