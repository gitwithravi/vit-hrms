import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/finance/ledgers",
    formErrors: {},
})

const ledger = {
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

export default ledger
