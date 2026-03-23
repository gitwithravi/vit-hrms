import department from "@stores/modules/company/department"
import designation from "@stores/modules/company/designation"
import branch from "@stores/modules/company/branch"

const initialState = () => ({})

const company = {
    namespaced: true,
    state: initialState,
    modules: {
        department,
        designation,
        branch,
    },
    mutations: {},
    actions: {},
    getters: {},
}
export default company
