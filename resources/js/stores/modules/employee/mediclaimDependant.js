import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/mediclaim-dependants",
    formErrors: {},
})

const mediclaimDependant = {
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

export default mediclaimDependant
