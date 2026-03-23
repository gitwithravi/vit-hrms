import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { toQueryString } from "@core/helpers/array"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/attendance/timesheets",
    subURL: "/app/attendance/timesheet",
    formErrors: {},
})

const timesheet = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async check({ state, commit }, payload) {
            return Api.custom({
                url: state.subURL + "/check",
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
        async clock({ state, commit }, payload) {
            let url = state.subURL + "/clock"
            return await Api.custom({
                url,
                method: "POST",
                data: payload,
            })
                .then((response) => {
                    toast.success(response.message)
                    return response
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async sync({ state, commit }, payload) {
            let url = state.subURL + "/sync"
            return await Api.custom({
                url: toQueryString(url, payload.params),
                method: "POST",
                data: payload,
            })
                .then((response) => {
                    toast.success(response.message)
                    return response
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

export default timesheet
