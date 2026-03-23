import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/leave/types",
    formErrors: {},
})

const type = {
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

export default type
