import axios from "axios"
import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { toQueryString } from "@core/helpers/array"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/search",
    formErrors: {},
})

const search = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        search({ state, commit }, payload) {
            let url = toQueryString(state.initURL, payload)
            return Api.custom({
                url: url,
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

export default search
