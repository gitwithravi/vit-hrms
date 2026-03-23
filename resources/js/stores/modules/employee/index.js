import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

import record from "@stores/modules/employee/record"
import workShift from "@stores/modules/employee/workShift"
import qualification from "@stores/modules/employee/qualification"
import account from "@stores/modules/employee/account"
import document from "@stores/modules/employee/document"
import experience from "@stores/modules/employee/experience"
import category from "@stores/modules/employee/category"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/employees",
    formErrors: {},
})

const employee = {
    namespaced: true,
    state: initialState,
    modules: {
        record,
        workShift,
        qualification,
        account,
        document,
        experience,
        category,
    },
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        getBasicInfo({ state, commit }, payload) {
            return Api.list(state.initURL + "/basic", payload.params)
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    Form.getErrors(error)
                    throw error
                })
        },
        confirmUser({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/" + payload.uuid + "/user/confirm",
                method: "POST",
                data: {
                    email: payload.form.email,
                },
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        getUser({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/" + payload.uuid + "/user",
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
        createUser({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/" + payload.uuid + "/user",
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
        updateUser({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/" + payload.uuid + "/user",
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

export default employee
