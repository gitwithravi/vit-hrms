import paymentMethod from "@stores/modules/finance/paymentMethod"
import ledgerType from "@stores/modules/finance/ledgerType"
import ledger from "@stores/modules/finance/ledger"
import transaction from "@stores/modules/finance/transaction"

const initialState = () => ({})

const finance = {
    namespaced: true,
    state: initialState,
    modules: {
        paymentMethod,
        ledgerType,
        ledger,
        transaction,
    },
    mutations: {},
    actions: {},
    getters: {},
}
export default finance
