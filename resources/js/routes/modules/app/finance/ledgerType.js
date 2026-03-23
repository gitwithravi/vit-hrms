export default [
    {
        path: "ledger-types",
        name: "FinanceLedgerType",
        redirect: { name: "FinanceLedgerTypeList" },
        meta: {
            label: "finance.ledger_type.ledger_type",
            icon: "fas fa-list-alt",
            hideChildren: true,
            permissions: ["finance:config"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "FinanceLedgerTypeList",
                meta: {
                    trans: "global.list",
                    label: "finance.ledger_type.ledger_types",
                },
                component: () =>
                    import("@views/Pages/Finance/LedgerType/Index.vue"),
            },
            {
                path: "create",
                name: "FinanceLedgerTypeCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "finance.ledger_type.ledger_type",
                },
                component: () =>
                    import("@views/Pages/Finance/LedgerType/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "FinanceLedgerTypeEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "finance.ledger_type.ledger_type",
                },
                component: () =>
                    import("@views/Pages/Finance/LedgerType/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "FinanceLedgerTypeDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "finance.ledger_type.ledger_type",
                },
                component: () =>
                    import("@views/Pages/Finance/LedgerType/Action.vue"),
            },
            {
                path: ":uuid",
                name: "FinanceLedgerTypeShow",
                meta: {
                    trans: "global.detail",
                    label: "finance.ledger_type.ledger_type",
                },
                component: () =>
                    import("@views/Pages/Finance/LedgerType/Show.vue"),
            },
        ],
    },
]
