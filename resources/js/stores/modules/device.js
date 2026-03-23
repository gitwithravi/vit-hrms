import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/devices",
    formErrors: {},
})

const device = {
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

export default device
