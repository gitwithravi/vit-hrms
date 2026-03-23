import paymentMethod from "./paymentMethod"
import ledgerType from "./ledgerType"
import ledger from "./ledger"
import transaction from "./transaction"

export default [
    {
        path: "finance",
        name: "Finance",
        redirect: { name: "FinanceTransaction" },
        meta: {
            label: "finance.finance",
            icon: "fas fa-file-invoice",
            permissions: [
                "finance:config",
                "ledger-type:read",
                "ledger:read",
                "transaction:read",
            ],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "config",
                name: "FinanceConfig",
                redirect: { name: "FinanceConfigGeneral" },
                meta: {
                    isNotNav: true,
                    type: "config",
                    icon: "fas fa-cog",
                    action: "config",
                    trans: "global.config",
                    label: "config.config",
                    permissions: ["finance:config"],
                },
                component: () =>
                    import("@views/Pages/Finance/Config/Index.vue"),
                children: [
                    {
                        path: "general",
                        name: "FinanceConfigGeneral",
                        meta: {
                            type: "config",
                            action: "config",
                            trans: "config.config",
                            label: "config.config",
                        },
                        component: () =>
                            import("@views/Pages/Finance/Config/General.vue"),
                    },
                    {
                        path: "payment-gateway",
                        name: "FinanceConfigPaymentGateway",
                        meta: {
                            label: "finance.config.payment_gateway",
                            icon: "far fa-building",
                            key: "payment_gateway",
                        },
                        component: () =>
                            import(
                                "@views/Pages/Finance/Config/PaymentGateway.vue"
                            ),
                    },
                ],
            },
            ...paymentMethod,
            ...ledgerType,
            ...ledger,
            ...transaction,
        ],
    },
]
