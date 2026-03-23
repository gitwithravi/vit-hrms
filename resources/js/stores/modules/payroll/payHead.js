import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/payroll/pay-heads",
    formErrors: {},
})

const payHead = {
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

export default payHead
