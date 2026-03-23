import payHead from "./payHead"
import salaryTemplate from "./salaryTemplate"
import salaryStructure from "./salaryStructure"

export default [
    {
        path: "payroll",
        name: "Payroll",
        redirect: { name: "PayrollList" },
        meta: {
            label: "payroll.payroll",
            icon: "fas fa-file-contract",
            permissions: [
                "payroll:read",
                "salary-template:read",
                "salary-structure:read",
            ],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "config",
                name: "PayrollConfig",
                redirect: { name: "PayrollConfigGeneral" },
                meta: {
                    isNotNav: true,
                    type: "config",
                    icon: "fas fa-cog",
                    action: "config",
                    trans: "global.config",
                    label: "config.config",
                    permissions: ["payroll:config"],
                },
                component: () =>
                    import("@views/Pages/Payroll/Config/Index.vue"),
                children: [
                    {
                        path: "general",
                        name: "PayrollConfigGeneral",
                        meta: {
                            type: "config",
                            action: "config",
                            trans: "config.config",
                            label: "config.config",
                        },
                        component: () =>
                            import("@views/Pages/Payroll/Config/General.vue"),
                    },
                ],
            },
            {
                path: "",
                name: "PayrollList",
                meta: {
                    label: "payroll.payroll",
                    icon: "fas fa-list-alt",
                    permissions: ["payroll:read"],
                },
                component: () => import("@views/Pages/Payroll/Index.vue"),
            },
            ...salaryStructure,
            ...salaryTemplate,
            ...payHead,
        ],
    },
    {
        path: "payrolls",
        name: "Payrolls",
        redirect: { name: "PayrollList" },
        meta: {
            isNotNav: true,
            label: "payroll.payrolls",
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "PayrollList",
                meta: {
                    trans: "global.list",
                    label: "payroll.payrolls",
                },
                component: () => import("@views/Pages/Payroll/Index.vue"),
            },
            {
                path: "create",
                name: "PayrollCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "payroll.payroll",
                    permissions: ["payroll:create"],
                },
                component: () => import("@views/Pages/Payroll/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "PayrollEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "payroll.payroll",
                    permissions: ["payroll:edit"],
                },
                component: () => import("@views/Pages/Payroll/Action.vue"),
            },
            {
                path: ":uuid",
                name: "PayrollShow",
                meta: {
                    trans: "global.detail",
                    label: "payroll.payroll",
                },
                component: () => import("@views/Pages/Payroll/Show.vue"),
            },
        ],
    },
]
