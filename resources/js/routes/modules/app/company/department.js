export default [
    {
        path: "departments",
        name: "CompanyDepartment",
        redirect: { name: "CompanyDepartmentList" },
        meta: {
            label: "company.department.department",
            icon: "fas fa-store",
            hideChildren: true,
            permissions: ["department:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "CompanyDepartmentList",
                meta: {
                    trans: "global.list",
                    label: "company.department.departments",
                },
                component: () =>
                    import("@views/Pages/Company/Department/Index.vue"),
            },
            {
                path: "create",
                name: "CompanyDepartmentCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "company.department.department",
                    permissions: ["department:create"],
                },
                component: () =>
                    import("@views/Pages/Company/Department/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "CompanyDepartmentEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "company.department.department",
                    permissions: ["department:edit"],
                },
                component: () =>
                    import("@views/Pages/Company/Department/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "CompanyDepartmentDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "company.department.department",
                    permissions: ["department:create"],
                },
                component: () =>
                    import("@views/Pages/Company/Department/Action.vue"),
            },
            {
                path: ":uuid",
                name: "CompanyDepartmentShow",
                meta: {
                    trans: "global.detail",
                    label: "company.department.department",
                },
                component: () =>
                    import("@views/Pages/Company/Department/Show.vue"),
            },
        ],
    },
]
