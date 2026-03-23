import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

import dashboard from "@stores/modules/task/dashboard"
import checklist from "@stores/modules/task/checklist"
import member from "@stores/modules/task/member"
import media from "@stores/modules/task/media"
import repeat from "@stores/modules/task/repeat"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/tasks",
    optionURL: "/app/options",
    formErrors: {},
})

const task = {
    namespaced: true,
    state: initialState,
    modules: {
        dashboard,
        checklist,
        member,
        media,
        repeat,
    },
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async updateTags({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/tags",
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
        async status({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/status",
                method: "POST",
                data: payload.data,
            })
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async toggleFavorite({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/favorite",
                method: "POST",
            })
                .then((response) => {
                    toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async addList({ state, commit }, payload) {
            return await Api.custom({
                url: state.optionURL + "?type=task_list",
                method: "POST",
                data: payload.form,
            })
                .then((response) => {
                    return response
                    // toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async reorderList({ state, commit }, payload) {
            await Api.custom({
                url: state.optionURL + "/reorder?type=task_list",
                method: "POST",
                data: payload,
            })
                .then((response) => {
                    // toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async moveList({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/lists/move",
                method: "POST",
                data: payload,
            })
                .then((response) => {
                    // toast.success(response.message)
                })
                .catch((error) => {
                    commit("SET_FORM_ERRORS", Form.getErrors(error))
                    throw error
                })
        },
        async reorderItems({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/reorder",
                method: "POST",
                data: payload,
            })
                .then((response) => {
                    // toast.success(response.message)
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

export default task
