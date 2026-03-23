export default [
    {
        path: "timesheets",
        name: "AttendanceTimesheet",
        redirect: { name: "AttendanceTimesheetList" },
        meta: {
            label: "attendance.timesheet.timesheet",
            icon: "fas fa-stopwatch",
            hideChildren: true,
            permissions: ["timesheet:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "AttendanceTimesheetList",
                meta: {
                    trans: "global.list",
                    label: "attendance.timesheet.timesheets",
                },
                component: () =>
                    import("@views/Pages/Attendance/Timesheet/Index.vue"),
            },
            {
                path: "create",
                name: "AttendanceTimesheetCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "attendance.timesheet.timesheet",
                    permissions: ["timesheet:create"],
                },
                component: () =>
                    import("@views/Pages/Attendance/Timesheet/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "AttendanceTimesheetEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "attendance.timesheet.timesheet",
                    permissions: ["timesheet:edit"],
                },
                component: () =>
                    import("@views/Pages/Attendance/Timesheet/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "AttendanceTimesheetDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "attendance.timesheet.timesheet",
                    permissions: ["timesheet:create"],
                },
                component: () =>
                    import("@views/Pages/Attendance/Timesheet/Action.vue"),
            },
            {
                path: ":uuid",
                name: "AttendanceTimesheetShow",
                meta: {
                    trans: "global.detail",
                    label: "attendance.timesheet.timesheet",
                },
                component: () =>
                    import("@views/Pages/Attendance/Timesheet/Show.vue"),
            },
        ],
    },
]
