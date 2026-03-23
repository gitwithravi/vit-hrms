export default [
    {
        path: "employee/category",
        name: "EmployeeCategory",
        redirect: { name: "EmployeeCategoryList" },
        meta: {
            label: "employee.employee-category",
            icon: "fas fa-user-tie",
            permissions: ["employee-category:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
    },
    {
        path: "employee/category",
        name: "EmployeeCategory",
        redirect: { name: "EmployeeCategoryList" },
        meta: {
            isNotNav: true,
            label: "employee.employee-category",
            icon: "fas fa-users",
            permissions: ["employee-category:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "EmployeeCategoryList",
                meta: {
                    label: "employee.employee-category",
                    icon: "fas fa-chevron-right",
                    permissions: ["employee-category:read"],
                },
                component: () => import("@views/Pages/Employee/Category/Index.vue"),
            },
        ],
    },
]
