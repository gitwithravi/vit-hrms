import holiday from "@stores/modules/calendar/holiday"

const initialState = () => ({})

const calendar = {
    namespaced: true,
    state: initialState,
    modules: {
        holiday,
    },
    mutations: {},
    actions: {},
    getters: {},
}
export default calendar
