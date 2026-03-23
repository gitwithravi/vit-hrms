import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/attendance/types",
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
