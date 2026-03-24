import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/teams/dfa",
    formErrors: {},
})

const dfa = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        resetState: actions.resetState,
        list: actions.list,
        create: actions.create,
        async delete({ state, commit }, payload) {
            await Api.destroy(state.initURL, payload.moduleUuid)
            .then((response) => {
                toast.success(response.message)
            })
            .catch((error) => {
                Form.getErrors(error)
                throw error
            })
        },
        async preRequisite({ state, commit }, payload) {
            let url = state.initURL + "/" + payload.uuid + state.module
            return await Api.custom(
                url + "/pre-requisite?module=" + payload.data
            )
            .then((response) => {
                return response
            })
            .catch((error) => {
                commit("SET_FORM_ERRORS", Form.getErrors(error))
                throw error
            })
        },
        async searchUser({ state, commit }, payload) {
            let url = state.initURL
            return await Api.custom(url + "/user/search?q=" + payload.query)
            .then((response) => {
                return response
            })
            .catch((error) => {
                commit("SET_FORM_ERRORS", Form.getErrors(error))
                throw error
            })
        },
        async assignDfaRole({ state, commit, dispatch }, payload) {
            await Api.store(state.initURL + "/assign", payload.form)
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

export default dfa
