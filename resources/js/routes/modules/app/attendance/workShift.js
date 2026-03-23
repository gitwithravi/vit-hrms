export default [
    {
        path: "work-shift",
        name: "AttendanceWorkShiftReport",
        meta: {
            trans: "global.report",
            label: "attendance.work_shift.work_shift",
            icon: "fas fa-clock",
            permissions: ["work-shift:read"],
        },
        component: () =>
            import("@views/Pages/Attendance/WorkShift/Assign/Report.vue"),
    },
    {
        path: "work-shift/assign",
        name: "AttendanceWorkShiftAssign",
        meta: {
            isNotNav: true,
            trans: "global.assign",
            label: "attendance.work_shift.work_shift",
            permissions: ["work-shift:assign"],
        },
        component: () =>
            import("@views/Pages/Attendance/WorkShift/Assign/Index.vue"),
    },
    {
        path: "work-shifts",
        name: "AttendanceWorkShift",
        redirect: { name: "AttendanceWorkShiftList" },
        meta: {
            isNotNav: true,
            label: "attendance.work_shift.work_shift",
            icon: "fas fa-clock",
            hideChildren: true,
            permissions: ["work-shift:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "AttendanceWorkShiftList",
                meta: {
                    trans: "global.list",
                    label: "attendance.work_shift.work_shifts",
                },
                component: () =>
                    import("@views/Pages/Attendance/WorkShift/Index.vue"),
            },
            {
                path: "create",
                name: "AttendanceWorkShiftCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "attendance.work_shift.work_shift",
                    permissions: ["work-shift:create"],
                },
                component: () =>
                    import("@views/Pages/Attendance/WorkShift/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "AttendanceWorkShiftEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "attendance.work_shift.work_shift",
                    permissions: ["work-shift:edit"],
                },
                component: () =>
                    import("@views/Pages/Attendance/WorkShift/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "AttendanceWorkShiftDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "attendance.work_shift.work_shift",
                    permissions: ["work-shift:create"],
                },
                component: () =>
                    import("@views/Pages/Attendance/WorkShift/Action.vue"),
            },
            {
                path: ":uuid",
                name: "AttendanceWorkShiftShow",
                meta: {
                    trans: "global.detail",
                    label: "attendance.work_shift.work_shift",
                },
                component: () =>
                    import("@views/Pages/Attendance/WorkShift/Show.vue"),
            },
        ],
    },
]
