export default [
    {
        path: "",
        name: "EmployeeExperienceList",
        meta: {
            trans: "global.list",
            label: "employee.experience.experiences",
        },
        component: () => import("@views/Pages/Employee/Experience/Index.vue"),
    },
    {
        path: "create",
        name: "EmployeeExperienceCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "employee.experience.experience",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Experience/Action.vue"),
    },
    {
        path: ":muuid/edit",
        name: "EmployeeExperienceEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "employee.experience.experience",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Experience/Action.vue"),
    },
    {
        path: ":muuid/duplicate",
        name: "EmployeeExperienceDuplicate",
        meta: {
            type: "duplicate",
            action: "create",
            trans: "global.duplicate",
            label: "employee.experience.experience",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Experience/Action.vue"),
    },
    {
        path: ":muuid",
        name: "EmployeeExperienceShow",
        meta: {
            trans: "global.detail",
            label: "employee.experience.experience",
            permissions: ["employee:edit"],
        },
        component: () => import("@views/Pages/Employee/Experience/Show.vue"),
    },
]
