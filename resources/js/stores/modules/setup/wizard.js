import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/setup-wizard",
    formErrors: {},
})

const wizard = {
    namespaced: true,
    state: initialState,
    mutations: {
        ...mutations,
    },
    actions: {
        getSteps({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL,
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    Form.getErrors(error)
                })
        },
    },
    getters: {
        ...getters,
    },
}

export default wizard
