import leaveType from "@stores/modules/leave/type"
import allocation from "@stores/modules/leave/allocation"
import request from "@stores/modules/leave/request"

const initialState = () => ({})

const leave = {
    namespaced: true,
    state: initialState,
    modules: {
        type: leaveType,
        allocation,
        request,
    },
    mutations: {},
    actions: {},
    getters: {},
}
export default leave
