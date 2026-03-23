import axios from "axios"
import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

import role from "@stores/modules/team/role"
import permission from "@stores/modules/team/permission"
import dfa from "@stores/modules/team/dfa"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/teams",
    formErrors: {},
})

const team = {
    namespaced: true,
    state: initialState,
    modules: {
        role,
        permission,
        dfa,
    },
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        list: actions.list,
        get: actions.get,
        delete: actions.delete,
        async create({ state, commit, dispatch }, payload) {
            await Api.store(state.initURL, payload.form)
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })

            await dispatch("config/get", false, { root: true })
        },
        async select({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/select",
                method: "POST",
                data: null,
            })
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async update({ state, commit, dispatch }, payload) {
            await Api.update(state.initURL, payload.uuid, payload.form)
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })

            await dispatch("config/get", false, { root: true })
        },
        async storeConfig({ state, commit }, payload) {
            return await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/config",
                method: "POST",
                data: payload.form,
            })
                .then((response) => {
                    commit("SET_FORM_ERRORS", {})
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

export default team
