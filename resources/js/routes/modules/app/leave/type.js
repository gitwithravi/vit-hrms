export default [
    {
        path: "types",
        name: "LeaveType",
        redirect: { name: "LeaveTypeList" },
        meta: {
            label: "leave.type.type",
            icon: "fas fa-list-alt",
            hideChildren: true,
            permissions: ["leave:config"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "LeaveTypeList",
                meta: {
                    trans: "global.list",
                    label: "leave.type.types",
                },
                component: () => import("@views/Pages/Leave/Type/Index.vue"),
            },
            {
                path: "create",
                name: "LeaveTypeCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "leave.type.type",
                },
                component: () => import("@views/Pages/Leave/Type/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "LeaveTypeEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "leave.type.type",
                },
                component: () => import("@views/Pages/Leave/Type/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "LeaveTypeDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "leave.type.type",
                },
                component: () => import("@views/Pages/Leave/Type/Action.vue"),
            },
            {
                path: ":uuid",
                name: "LeaveTypeShow",
                meta: {
                    trans: "global.detail",
                    label: "leave.type.type",
                },
                component: () => import("@views/Pages/Leave/Type/Show.vue"),
            },
        ],
    },
]
