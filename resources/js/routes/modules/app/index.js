import dashboard from "./dashboard"
import team from "./team"
import user from "./user"
import utility from "./utility"
import config from "./config"
import product from "./product"

import company from "./company"
import employee from "./employee"
import employeeCategory from "./employee-category"
import attendance from "./attendance"
import leave from "./leave"
import payroll from "./payroll"
import finance from "./finance"
import calendar from "./calendar"
import task from "./task"
import device from "./device"

export default [
    ...dashboard,
    ...company,
    ...employee,
    ...employeeCategory,
    ...attendance,
    ...leave,
    ...payroll,
    ...finance,
    ...calendar,
    ...task,
    ...device,
    ...team,
    ...user,
    ...utility,
    ...config,
    ...product,
]
