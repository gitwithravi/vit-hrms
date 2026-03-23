export default [
    {
        path: "types",
        name: "AttendanceType",
        redirect: { name: "AttendanceTypeList" },
        meta: {
            label: "attendance.type.type",
            icon: "fas fa-list-alt",
            hideChildren: true,
            permissions: ["attendance:config"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "AttendanceTypeList",
                meta: {
                    trans: "global.list",
                    label: "attendance.type.types",
                },
                component: () =>
                    import("@views/Pages/Attendance/Type/Index.vue"),
            },
            {
                path: "create",
                name: "AttendanceTypeCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "attendance.type.type",
                },
                component: () =>
                    import("@views/Pages/Attendance/Type/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "AttendanceTypeEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "attendance.type.type",
                },
                component: () =>
                    import("@views/Pages/Attendance/Type/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "AttendanceTypeDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "attendance.type.type",
                },
                component: () =>
                    import("@views/Pages/Attendance/Type/Action.vue"),
            },
            {
                path: ":uuid",
                name: "AttendanceTypeShow",
                meta: {
                    trans: "global.detail",
                    label: "attendance.type.type",
                },
                component: () =>
                    import("@views/Pages/Attendance/Type/Show.vue"),
            },
        ],
    },
]
