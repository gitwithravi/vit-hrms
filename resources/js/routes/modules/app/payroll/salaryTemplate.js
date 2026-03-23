export default [
    {
        path: "salary-templates",
        name: "PayrollSalaryTemplate",
        redirect: { name: "PayrollSalaryTemplateList" },
        meta: {
            label: "payroll.salary_template.salary_template",
            icon: "fas fa-folder-open",
            hideChildren: true,
            permissions: ["salary-template:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "PayrollSalaryTemplateList",
                meta: {
                    trans: "global.list",
                    label: "payroll.salary_template.salary_templates",
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryTemplate/Index.vue"),
            },
            {
                path: "create",
                name: "PayrollSalaryTemplateCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "payroll.salary_template.salary_template",
                    permissions: ["salary-template:create"],
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryTemplate/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "PayrollSalaryTemplateEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "payroll.salary_template.salary_template",
                    permissions: ["salary-template:edit"],
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryTemplate/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "PayrollSalaryTemplateDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "payroll.salary_template.salary_template",
                    permissions: ["salary-template:create"],
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryTemplate/Action.vue"),
            },
            {
                path: ":uuid",
                name: "PayrollSalaryTemplateShow",
                meta: {
                    trans: "global.detail",
                    label: "payroll.salary_template.salary_template",
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryTemplate/Show.vue"),
            },
        ],
    },
]
