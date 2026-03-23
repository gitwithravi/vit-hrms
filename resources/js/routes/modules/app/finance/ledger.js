export default [
    {
        path: "ledgers",
        name: "FinanceLedger",
        redirect: { name: "FinanceLedgerList" },
        meta: {
            label: "finance.ledger.ledger",
            icon: "fas fa-book",
            hideChildren: true,
            permissions: ["ledger:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "FinanceLedgerList",
                meta: {
                    trans: "global.list",
                    label: "finance.ledger.ledgers",
                },
                component: () =>
                    import("@views/Pages/Finance/Ledger/Index.vue"),
            },
            {
                path: "create",
                name: "FinanceLedgerCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "finance.ledger.ledger",
                    permissions: ["ledger:create"],
                },
                component: () =>
                    import("@views/Pages/Finance/Ledger/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "FinanceLedgerEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "finance.ledger.ledger",
                    permissions: ["ledger:edit"],
                },
                component: () =>
                    import("@views/Pages/Finance/Ledger/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "FinanceLedgerDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "finance.ledger.ledger",
                    permissions: ["ledger:create"],
                },
                component: () =>
                    import("@views/Pages/Finance/Ledger/Action.vue"),
            },
            {
                path: ":uuid",
                name: "FinanceLedgerShow",
                meta: {
                    trans: "global.detail",
                    label: "finance.ledger.ledger",
                },
                component: () => import("@views/Pages/Finance/Ledger/Show.vue"),
            },
        ],
    },
]
