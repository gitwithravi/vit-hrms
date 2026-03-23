import employee from "./employee"

export default [
    {
        path: "employee",
        name: "Employee",
        redirect: { name: "EmployeeList" },
        meta: {
            label: "employee.employee",
            icon: "fas fa-user-tie",
            permissions: ["employee:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
    },
    {
        path: "employees",
        name: "Employees",
        redirect: { name: "EmployeeList" },
        meta: {
            isNotNav: true,
            label: "employee.employees",
            icon: "fas fa-users",
            permissions: ["employee:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [...employee],
    },
]
