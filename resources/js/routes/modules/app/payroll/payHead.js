export default [
    {
        path: "pay-heads",
        name: "PayrollPayHead",
        redirect: { name: "PayrollPayHeadList" },
        meta: {
            label: "payroll.pay_head.pay_head",
            icon: "fas fa-list-alt",
            hideChildren: true,
            permissions: ["payroll:config"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "PayrollPayHeadList",
                meta: {
                    trans: "global.list",
                    label: "payroll.pay_head.pay_heads",
                },
                component: () =>
                    import("@views/Pages/Payroll/PayHead/Index.vue"),
            },
            {
                path: "create",
                name: "PayrollPayHeadCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "payroll.pay_head.pay_head",
                },
                component: () =>
                    import("@views/Pages/Payroll/PayHead/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "PayrollPayHeadEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "payroll.pay_head.pay_head",
                },
                component: () =>
                    import("@views/Pages/Payroll/PayHead/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "PayrollPayHeadDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "payroll.pay_head.pay_head",
                },
                component: () =>
                    import("@views/Pages/Payroll/PayHead/Action.vue"),
            },
            {
                path: ":uuid",
                name: "PayrollPayHeadShow",
                meta: {
                    trans: "global.detail",
                    label: "payroll.pay_head.pay_head",
                },
                component: () =>
                    import("@views/Pages/Payroll/PayHead/Show.vue"),
            },
        ],
    },
]
