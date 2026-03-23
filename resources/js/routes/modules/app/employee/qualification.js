export default [
    {
        path: "",
        name: "EmployeeQualificationList",
        meta: {
            trans: "global.list",
            label: "employee.qualification.qualifications",
        },
        component: () =>
            import("@views/Pages/Employee/Qualification/Index.vue"),
    },
    {
        path: "create",
        name: "EmployeeQualificationCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "employee.qualification.qualification",
            permissions: ["employee:edit"],
        },
        component: () =>
            import("@views/Pages/Employee/Qualification/Action.vue"),
    },
    {
        path: ":muuid/edit",
        name: "EmployeeQualificationEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "employee.qualification.qualification",
            permissions: ["employee:edit"],
        },
        component: () =>
            import("@views/Pages/Employee/Qualification/Action.vue"),
    },
    {
        path: ":muuid/duplicate",
        name: "EmployeeQualificationDuplicate",
        meta: {
            type: "duplicate",
            action: "create",
            trans: "global.duplicate",
            label: "employee.qualification.qualification",
            permissions: ["employee:edit"],
        },
        component: () =>
            import("@views/Pages/Employee/Qualification/Action.vue"),
    },
    {
        path: ":muuid",
        name: "EmployeeQualificationShow",
        meta: {
            trans: "global.detail",
            label: "employee.qualification.qualification",
        },
        component: () => import("@views/Pages/Employee/Qualification/Show.vue"),
    },
]
