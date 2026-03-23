export default [
    {
        path: "",
        name: "EmployeeDocumentList",
        meta: {
            trans: "global.list",
            label: "employee.document.documents",
        },
        component: () => import("@views/Pages/Employee/Document/Index.vue"),
    },
    {
        path: "create",
        name: "EmployeeDocumentCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "employee.document.document",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Document/Action.vue"),
    },
    {
        path: ":muuid/edit",
        name: "EmployeeDocumentEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "employee.document.document",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Document/Action.vue"),
    },
    {
        path: ":muuid/duplicate",
        name: "EmployeeDocumentDuplicate",
        meta: {
            type: "duplicate",
            action: "create",
            trans: "global.duplicate",
            label: "employee.document.document",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Document/Action.vue"),
    },
    {
        path: ":muuid",
        name: "EmployeeDocumentShow",
        meta: {
            trans: "global.detail",
            label: "employee.document.document",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Document/Show.vue"),
    },
]
