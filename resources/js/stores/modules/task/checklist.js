import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/globalNestedModule"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/tasks",
    module: "/checklists",
    formErrors: {},
})

const checklist = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async toggleStatus({ state, commit }, payload) {
            await Api.custom({
                url:
                    state.initURL +
                    "/" +
                    payload.uuid +
                    state.module +
                    "/" +
                    payload.moduleUuid +
                    "/status",
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
    },
    getters: {
        ...getters,
    },
}

export default checklist
