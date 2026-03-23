import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/globalNestedModule"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/tasks",
    module: "/repeat",
    formErrors: {},
})

const repeat = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
        async updateRepeatation({ state, commit }, payload) {
            await Api.custom({
                url: state.initURL + "/" + payload.uuid + "/repeat",
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

export default repeat
