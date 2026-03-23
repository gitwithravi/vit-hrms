export default [
    {
        path: "branches",
        name: "CompanyBranch",
        redirect: { name: "CompanyBranchList" },
        meta: {
            label: "company.branch.branch",
            icon: "fas fa-sitemap",
            hideChildren: true,
            permissions: ["branch:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "CompanyBranchList",
                meta: {
                    trans: "global.list",
                    label: "company.branch.branches",
                },
                component: () =>
                    import("@views/Pages/Company/Branch/Index.vue"),
            },
            {
                path: "create",
                name: "CompanyBranchCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "company.branch.branch",
                    permissions: ["branch:create"],
                },
                component: () =>
                    import("@views/Pages/Company/Branch/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "CompanyBranchEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "company.branch.branch",
                    permissions: ["branch:edit"],
                },
                component: () =>
                    import("@views/Pages/Company/Branch/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "CompanyBranchDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "company.branch.branch",
                    permissions: ["branch:create"],
                },
                component: () =>
                    import("@views/Pages/Company/Branch/Action.vue"),
            },
            {
                path: ":uuid",
                name: "CompanyBranchShow",
                meta: {
                    trans: "global.detail",
                    label: "company.branch.branch",
                },
                component: () => import("@views/Pages/Company/Branch/Show.vue"),
            },
        ],
    },
]
