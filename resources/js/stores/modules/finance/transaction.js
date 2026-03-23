import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/finance/transactions",
    formErrors: {},
})

const transaction = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async cancel({ state, commit }, payload) {
            return await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/cancel",
                method: "POST",
            })
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
    },
    getters: {
        ...getters,
    },
}

export default transaction
