import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/product",
    formErrors: {},
})

const product = {
    namespaced: true,
    state: initialState,
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        info({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/info",
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        update({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/update",
                method: "POST",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        license({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/license",
                method: "POST",
                data: payload.form,
            })
                .then((response) => {
                    return true
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

export default product
