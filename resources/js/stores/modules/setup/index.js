import wizard from "@stores/modules/setup/wizard"
import install from "@stores/modules/setup/install"

const initialState = () => ({})

const setup = {
    namespaced: true,
    modules: {
        install,
        wizard,
    },
    state: initialState,
    mutations: {},
    actions: {},
    getters: {},
}

export default setup
