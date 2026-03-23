export default [
    {
        path: "designations",
        name: "CompanyDesignation",
        redirect: { name: "CompanyDesignationList" },
        meta: {
            label: "company.designation.designation",
            icon: "fas fa-id-badge",
            hideChildren: true,
            permissions: ["designation:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "CompanyDesignationList",
                meta: {
                    trans: "global.list",
                    label: "company.designation.designations",
                },
                component: () =>
                    import("@views/Pages/Company/Designation/Index.vue"),
            },
            {
                path: "create",
                name: "CompanyDesignationCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "company.designation.designation",
                    permissions: ["designation:create"],
                },
                component: () =>
                    import("@views/Pages/Company/Designation/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "CompanyDesignationEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "company.designation.designation",
                    permissions: ["designation:edit"],
                },
                component: () =>
                    import("@views/Pages/Company/Designation/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "CompanyDesignationDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "company.designation.designation",
                    permissions: ["designation:create"],
                },
                component: () =>
                    import("@views/Pages/Company/Designation/Action.vue"),
            },
            {
                path: ":uuid",
                name: "CompanyDesignationShow",
                meta: {
                    trans: "global.detail",
                    label: "company.designation.designation",
                },
                component: () =>
                    import("@views/Pages/Company/Designation/Show.vue"),
            },
        ],
    },
]
