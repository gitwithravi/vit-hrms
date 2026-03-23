import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { toQueryString } from "@core/helpers/array"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/attendance/work-shifts",
    subURL: "/app/attendance/work-shift",
    formErrors: {},
})

const workShift = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async assignPreRequisite({ state, commit }, payload) {
            return Api.custom({
                url: state.subURL + "/assign/pre-requisite",
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
        async fetchEmployee({ state, commit }, payload) {
            let url = state.subURL + "/assign/fetch"
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
        async assign({ state, commit }, payload) {
            let url = state.subURL + "/assign"
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
    },
    getters: {
        ...getters,
    },
}

export default workShift
