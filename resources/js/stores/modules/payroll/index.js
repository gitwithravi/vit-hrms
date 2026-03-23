import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { toQueryString } from "@core/helpers/array"
import { mutations, actions, getters } from "@stores/global"

import payHead from "@stores/modules/payroll/payHead"
import salaryTemplate from "@stores/modules/payroll/salaryTemplate"
import salaryStructure from "@stores/modules/payroll/salaryStructure"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/payrolls",
    formErrors: {},
})

const payroll = {
    namespaced: true,
    state: initialState,
    modules: {
        payHead,
        salaryTemplate,
        salaryStructure,
    },
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async fetchDetail({ state, commit }, payload) {
            let url = state.initURL + "/fetch"
            return Api.custom({
                url: toQueryString(url, payload.params),
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
        async generate({ state, commit }, payload) {
            let url = state.initURL
            return await Api.custom({
                url: toQueryString(url, payload.routeQuery),
                method: "POST",
                data: payload.form,
            })
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async edit({ state, commit }, payload) {
            let url = state.initURL + "/" + payload.uuid
            return await Api.custom({
                url: toQueryString(url, payload.routeQuery),
                method: "PATCH",
                data: payload.form,
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
export default payroll
