import { mutations, actions, getters } from "@stores/globalNestedModule"

const initialState = () => ({
    initURL: "/app/employees",
    module: "/work-shifts",
    formErrors: {},
})

const workShift = {
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

export default workShift
