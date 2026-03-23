export default [
    {
        path: "transactions",
        name: "FinanceTransaction",
        redirect: { name: "FinanceTransactionList" },
        meta: {
            label: "finance.transaction.transaction",
            icon: "fas fa-exchange-alt",
            hideChildren: true,
            permissions: ["transaction:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "FinanceTransactionList",
                meta: {
                    trans: "global.list",
                    label: "finance.transaction.transactions",
                },
                component: () =>
                    import("@views/Pages/Finance/Transaction/Index.vue"),
            },
            {
                path: "create",
                name: "FinanceTransactionCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "finance.transaction.transaction",
                    permissions: ["transaction:create"],
                },
                component: () =>
                    import("@views/Pages/Finance/Transaction/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "FinanceTransactionEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "finance.transaction.transaction",
                    permissions: ["transaction:edit"],
                },
                component: () =>
                    import("@views/Pages/Finance/Transaction/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "FinanceTransactionDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "finance.transaction.transaction",
                    permissions: ["transaction:create"],
                },
                component: () =>
                    import("@views/Pages/Finance/Transaction/Action.vue"),
            },
            {
                path: ":uuid",
                name: "FinanceTransactionShow",
                meta: {
                    trans: "global.detail",
                    label: "finance.transaction.transaction",
                },
                component: () =>
                    import("@views/Pages/Finance/Transaction/Show.vue"),
            },
        ],
    },
]
