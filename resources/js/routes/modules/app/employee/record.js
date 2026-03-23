export default [
    {
        path: "",
        name: "EmployeeRecordList",
        meta: {
            trans: "global.list",
            label: "employee.record.records",
        },
        component: () => import("@views/Pages/Employee/Record/Index.vue"),
    },
    {
        path: "create",
        name: "EmployeeRecordCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "employee.record.record",
            permissions: ["employment-record:manage"],
        },
        component: () => import("@views/Pages/Employee/Record/Action.vue"),
    },
    {
        path: ":muuid/edit",
        name: "EmployeeRecordEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "employee.record.record",
            permissions: ["employment-record:manage"],
        },
        component: () => import("@views/Pages/Employee/Record/Action.vue"),
    },
    {
        path: ":muuid",
        name: "EmployeeRecordShow",
        meta: {
            trans: "global.detail",
            label: "employee.record.record",
        },
        component: () => import("@views/Pages/Employee/Record/Show.vue"),
    },
]
