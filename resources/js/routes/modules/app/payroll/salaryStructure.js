export default [
    {
        path: "salary-structures",
        name: "PayrollSalaryStructure",
        redirect: { name: "PayrollSalaryStructureList" },
        meta: {
            label: "payroll.salary_structure.salary_structure",
            icon: "fas fa-clone",
            hideChildren: true,
            permissions: ["salary-structure:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "PayrollSalaryStructureList",
                meta: {
                    trans: "global.list",
                    label: "payroll.salary_structure.salary_structures",
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryStructure/Index.vue"),
            },
            {
                path: "create",
                name: "PayrollSalaryStructureCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "payroll.salary_structure.salary_structure",
                    permissions: ["salary-structure:create"],
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryStructure/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "PayrollSalaryStructureEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "payroll.salary_structure.salary_structure",
                    permissions: ["salary-structure:edit"],
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryStructure/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "PayrollSalaryStructureDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "payroll.salary_structure.salary_structure",
                    permissions: ["salary-structure:create"],
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryStructure/Action.vue"),
            },
            {
                path: ":uuid",
                name: "PayrollSalaryStructureShow",
                meta: {
                    trans: "global.detail",
                    label: "payroll.salary_structure.salary_structure",
                },
                component: () =>
                    import("@views/Pages/Payroll/SalaryStructure/Show.vue"),
            },
        ],
    },
]
