import axios from "axios"
import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/tasks/dashboard/",
    formErrors: {},
})

const dashboard = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        async getStat({ state, commit }) {
            return await Api.custom({
                url: state.initURL + "stat",
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    throw error
                })
        },
        async getFavorite({ state, commit }) {
            return await Api.custom({
                url: state.initURL + "favorite",
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    throw error
                })
        },
        async getChart({ state, commit }) {
            return await Api.custom({
                url: state.initURL + "chart",
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    throw error
                })
        },
        async getRecord({ state, commit }, payload) {
            return await Api.custom({
                url: state.initURL + "record?type=" + payload.type,
                method: "GET",
            })
                .then((response) => {
                    return response
                })
                .catch((error) => {
                    throw error
                })
        },
    },
    getters: {},
}

export default dashboard
