import * as Api from "@core/apis"
import * as Form from "@core/utils/form"
import { useToast } from "vue-toastification"
import { mutations, actions, getters } from "@stores/global"

const toast = useToast()

const initialState = () => ({
    initURL: "/app/employee-category",
    formErrors: {},
    selectedEmployee: {},
    showFormModal: false,
    showAssignModal: false,
})

const employee = {
    namespaced: true,
    state: initialState,
    modules: {
    },
    mutations: {
        ...mutations,
        // UPDATE_SHOW_FORM_MODAL(state, payload = false) {
        //     state.showFormModal = payload;
        // },
    },
    actions: {
        ...actions,
        updateShowFormModal({ state, commit }, payload) {
            state.showFormModal = payload;
        },
        updateEmployeeCategory({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/" + payload.id,
                method: "POST",
                data: payload.data,
            }).then((response) => {
                toast.success(response.message)
            }).catch((error) => {
                commit("SET_FORM_ERRORS", Form.getErrors(error))
                throw error
            })
        },
        updateSelectedEmployee({ state, commit }, payload) {
            state.selectedEmployee = payload;
        },
        updateShowAssignModal({ state }, payload) {
            state.showAssignModal = payload;
        },
        bulkAssignCategory({ state, commit }, payload) {
            return Api.custom({
                url: state.initURL + "/bulk-assign",
                method: "POST",
                data: payload,
            }).then((response) => {
                toast.success(response.message)
            }).catch((error) => {
                commit("SET_FORM_ERRORS", Form.getErrors(error))
                throw error
            })
        },
    },
    getters: {
        ...getters,
        getShowFormModal(state) {
            return state.showFormModal;
        },
        getSelectedEmployee(state) {
            return state.selectedEmployee;
        },
        getShowAssignModal(state) {
            return state.showAssignModal;
        },
    },
}

export default employee
