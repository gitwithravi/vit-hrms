import attendanceType from "./type"
import workShift from "./workShift"
import timesheet from "./timesheet"

export default [
    {
        path: "attendance",
        name: "Attendance",
        redirect: { name: "AttendanceList" },
        meta: {
            permissions: ["attendance:read"],
            label: "attendance.attendance",
            icon: "fas fa-table",
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            ...workShift,
            ...timesheet,
            {
                path: "",
                name: "AttendanceList",
                meta: {
                    icon: "fa-solid fa-table-list",
                    label: "attendance.attendance",
                    permissions: ["attendance:read"],
                },
                component: () => import("@views/Pages/Attendance/Index.vue"),
            },
            {
                path: "mark",
                name: "AttendanceMark",
                meta: {
                    isNotNav: true,
                    label: "attendance.mark",
                    permissions: ["attendance:mark"],
                },
                component: () => import("@views/Pages/Attendance/Mark.vue"),
            },
            {
                path: "production",
                name: "AttendanceProduction",
                meta: {
                    isNotNav: true,
                    label: "attendance.mark_production",
                    permissions: ["attendance:mark"],
                },
                component: () =>
                    import("@views/Pages/Attendance/MarkProduction.vue"),
            },
            ...attendanceType,
            {
                path: "config",
                name: "AttendanceConfig",
                redirect: { name: "AttendanceConfigGeneral" },
                meta: {
                    isNotNav: true,
                    type: "config",
                    icon: "fas fa-cog",
                    action: "config",
                    trans: "global.config",
                    label: "config.config",
                    permissions: ["attendance:config"],
                },
                component: () =>
                    import("@views/Pages/Attendance/Config/Index.vue"),
                children: [
                    {
                        path: "general",
                        name: "AttendanceConfigGeneral",
                        meta: {
                            type: "config",
                            action: "config",
                            trans: "config.config",
                            label: "config.config",
                        },
                        component: () =>
                            import(
                                "@views/Pages/Attendance/Config/General.vue"
                            ),
                    },
                ],
            },
        ],
    },
]
