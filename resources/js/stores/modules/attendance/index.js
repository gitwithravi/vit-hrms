import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { toQueryString } from "@core/helpers/array"
import attendanceType from "@stores/modules/attendance/type"
import workShift from "@stores/modules/attendance/workShift"
import timesheet from "@stores/modules/attendance/timesheet"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/attendance",
    formErrors: {},
})

const attendance = {
    namespaced: true,
    state: initialState,
    modules: {
        type: attendanceType,
        workShift: workShift,
        timesheet: timesheet,
    },
    mutations: {
        SET_FORM_ERRORS: (state, payload = {}) => {
            state.formErrors = payload
        },
        RESET_STATE: (state) => {
            state = initialState
        },
    },
    actions: {
        resetFormErrors({ commit }) {
            commit("SET_FORM_ERRORS")
        },
        async preRequisite({ state, commit }, payload) {
            let url = state.initURL + "/pre-requisite"
            return Api.custom({
                url,
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    Form.getErrors(error)
                    throw error
                })
        },
        async listAttendance({ state, commit }, payload) {
            let url = state.initURL + "/list"
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
        async fetchEmployee({ state, commit }, payload) {
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
        async markAttendance({ state, commit }, payload) {
            let url = state.initURL + "/mark"
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
        async fetchProduction({ state, commit }, payload) {
            let url = state.initURL + "/production"
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
        async markProduction({ state, commit }, payload) {
            let url = state.initURL + "/production"
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
        resetState({ commit }) {
            commit("RESET_STATE")
        },
    },
    getters: {
        getFormErrors: (state) => state.formErrors,
    },
}
export default attendance
