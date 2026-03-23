import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/globalNestedModule"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/teams",
    module: "/roles",
    formErrors: {},
})

const role = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        resetFormErrors: actions.resetFormErrors,
        resetState: actions.resetState,
        list: actions.list,
        create: actions.create,
        delete: actions.delete,
    },
    getters: {
        ...getters,
    },
}

export default role
