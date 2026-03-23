import { createStore } from "vuex"

import setup from "@stores/modules/setup"
import navigation from "@stores/modules/navigation"
import config from "@stores/modules/config"
import layout from "@stores/modules/layout"
import dashboard from "@stores/modules/dashboard"
import image from "@stores/modules/image"
import auth from "@stores/modules/auth"
import user from "@stores/modules/user"
import team from "@stores/modules/team"
import utility from "@stores/modules/utility"
import option from "@stores/modules/option"
import tag from "@stores/modules/tag"
import moduleImport from "@stores/modules/moduleImport"
import product from "@stores/modules/product"

import company from "@stores/modules/company"
import employee from "@stores/modules/employee"
import calendar from "@stores/modules/calendar"
import leave from "@stores/modules/leave"
import attendance from "@stores/modules/attendance"
import payroll from "@stores/modules/payroll"
import finance from "@stores/modules/finance"
import task from "@stores/modules/task"
import device from "@stores/modules/device"

const initialState = () => ({})

const store = createStore({
    modules: {
        setup,
        navigation,
        config,
        layout,
        dashboard,
        image,
        auth,
        user,
        utility,
        option,
        tag,
        moduleImport,
        product,
        team,
        company,
        employee,
        calendar,
        leave,
        attendance,
        payroll,
        finance,
        task,
        device,
    },
    state: initialState,
    mutations: {},
    actions: {},
    getters: {},
})

export default store
