import { mutations, actions, getters } from "@stores/global"

const initialState = () => ({
    initURL: "/app/finance/ledger-types",
    formErrors: {},
})

const ledgerType = {
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

export default ledgerType
