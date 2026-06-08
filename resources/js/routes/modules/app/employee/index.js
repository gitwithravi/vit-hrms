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
        children: [
            {
                path: "employees",
                name: "EmployeeNavList",
                redirect: { name: "EmployeeList" },
                meta: {
                    label: "employee.employees",
                    icon: "fas fa-users",
                    permissions: ["employee:read"],
                },
            },
            {
                path: "mediclaim-dependants",
                name: "MediclaimDependant",
                meta: {
                    label: "employee.mediclaim.dependants",
                    icon: "fas fa-notes-medical",
                    permissions: ["employee:read"],
                },
                component: () =>
                    import(
                        "@views/Pages/Employee/MediclaimDependant/Index.vue"
                    ),
            },
        ],
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
