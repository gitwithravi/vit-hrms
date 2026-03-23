export default [
    {
        path: "",
        name: "EmployeeAccountList",
        meta: {
            trans: "global.list",
            label: "finance.account.accounts",
        },
        component: () => import("@views/Pages/Employee/Account/Index.vue"),
    },
    {
        path: "create",
        name: "EmployeeAccountCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "finance.account.account",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Account/Action.vue"),
    },
    {
        path: ":muuid/edit",
        name: "EmployeeAccountEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "finance.account.account",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Account/Action.vue"),
    },
    {
        path: ":muuid/duplicate",
        name: "EmployeeAccountDuplicate",
        meta: {
            type: "duplicate",
            action: "create",
            trans: "global.duplicate",
            label: "finance.account.account",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Account/Action.vue"),
    },
    {
        path: ":muuid",
        name: "EmployeeAccountShow",
        meta: {
            trans: "global.detail",
            label: "finance.account.account",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Account/Show.vue"),
    },
]
