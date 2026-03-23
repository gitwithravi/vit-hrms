import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/finance/payment-methods",
    formErrors: {},
})

const paymentMethod = {
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

export default paymentMethod
