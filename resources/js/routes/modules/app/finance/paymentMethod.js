export default [
    {
        path: "payment-methods",
        name: "FinancePaymentMethod",
        redirect: { name: "FinancePaymentMethodList" },
        meta: {
            label: "finance.payment_method.payment_method",
            icon: "fas fa-right-long",
            hideChildren: true,
            permissions: ["finance:config"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "FinancePaymentMethodList",
                meta: {
                    trans: "global.list",
                    label: "finance.payment_method.payment_methods",
                },
                component: () =>
                    import("@views/Pages/Finance/PaymentMethod/Index.vue"),
            },
            {
                path: "create",
                name: "FinancePaymentMethodCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "finance.payment_method.payment_method",
                },
                component: () =>
                    import("@views/Pages/Finance/PaymentMethod/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "FinancePaymentMethodEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "finance.payment_method.payment_method",
                },
                component: () =>
                    import("@views/Pages/Finance/PaymentMethod/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "FinancePaymentMethodDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "finance.payment_method.payment_method",
                },
                component: () =>
                    import("@views/Pages/Finance/PaymentMethod/Action.vue"),
            },
            {
                path: ":uuid",
                name: "FinancePaymentMethodShow",
                meta: {
                    trans: "global.detail",
                    label: "finance.payment_method.payment_method",
                },
                component: () =>
                    import("@views/Pages/Finance/PaymentMethod/Show.vue"),
            },
        ],
    },
]
