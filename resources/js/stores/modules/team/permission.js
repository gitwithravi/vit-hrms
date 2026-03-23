import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/teams",
    module: "/permissions",
    formErrors: {},
})

const permission = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        resetState: actions.resetState,
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
        async roleWiseAssign({ state, commit, dispatch }, payload) {
            let url = state.initURL + "/" + payload.uuid + state.module
            await Api.store(url + "/role/assign", payload.form)
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })

            await dispatch("auth/user/fetch", null, { root: true })
        },
        async search({ state, commit }, payload) {
            let url = state.initURL + "/" + payload.uuid + state.module
            return await Api.custom(url + "/search?q=" + payload.query)
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async searchUser({ state, commit }, payload) {
            let url = state.initURL + "/" + payload.uuid + state.module
            return await Api.custom(url + "/user/search?q=" + payload.query)
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async userWiseAssign({ state, commit, dispatch }, payload) {
            let url = state.initURL + "/" + payload.uuid + state.module
            await Api.store(url + "/user/assign", payload.form)
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })

            await dispatch("auth/user/fetch", null, { root: true })
        },
    },
    getters: {
        ...getters,
    },
}

export default permission
