export default [
    {
        path: "",
        name: "EmployeeWorkShiftList",
        meta: {
            trans: "global.list",
            label: "attendance.work_shift.work_shifts",
            permissions: ["work-shift:assign"],
        },
        component: () => import("@views/Pages/Employee/WorkShift/Index.vue"),
    },
    {
        path: "create",
        name: "EmployeeWorkShiftCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "attendance.work_shift.work_shift",
            permissions: ["work-shift:assign"],
        },
        component: () => import("@views/Pages/Employee/WorkShift/Action.vue"),
    },
    {
        path: ":muuid/edit",
        name: "EmployeeWorkShiftEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "attendance.work_shift.work_shift",
            permissions: ["work-shift:assign"],
        },
        component: () => import("@views/Pages/Employee/WorkShift/Action.vue"),
    },
    {
        path: ":muuid/duplicate",
        name: "EmployeeWorkShiftDuplicate",
        meta: {
            type: "duplicate",
            action: "create",
            trans: "global.duplicate",
            label: "attendance.work_shift.work_shift",
            permissions: ["work-shift:assign"],
        },
        component: () => import("@views/Pages/Employee/WorkShift/Action.vue"),
    },
    {
        path: ":muuid",
        name: "EmployeeWorkShiftShow",
        meta: {
            trans: "global.detail",
            label: "attendance.work_shift.work_shift",
            permissions: ["work-shift:assign"],
        },
        component: () => import("@views/Pages/Employee/WorkShift/Show.vue"),
    },
]
