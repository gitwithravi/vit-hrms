export default [
    {
        path: "requests",
        name: "LeaveRequest",
        redirect: { name: "LeaveRequestList" },
        meta: {
            label: "leave.request.request",
            icon: "fas fa-file-medical-alt",
            hideChildren: true,
            permissions: ["leave-request:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "LeaveRequestList",
                meta: {
                    trans: "global.list",
                    label: "leave.request.requests",
                },
                component: () => import("@views/Pages/Leave/Request/Index.vue"),
            },
            {
                path: "create",
                name: "LeaveRequestCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "leave.request.request",
                    permissions: ["leave-request:create"],
                },
                component: () =>
                    import("@views/Pages/Leave/Request/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "LeaveRequestEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "leave.request.request",
                    permissions: ["leave-request:edit"],
                },
                component: () =>
                    import("@views/Pages/Leave/Request/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "LeaveRequestDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "leave.request.request",
                    permissions: ["leave-request:create"],
                },
                component: () =>
                    import("@views/Pages/Leave/Request/Action.vue"),
            },
            {
                path: ":uuid",
                name: "LeaveRequestShow",
                meta: {
                    trans: "global.detail",
                    label: "leave.request.request",
                },
                component: () => import("@views/Pages/Leave/Request/Show.vue"),
            },
        ],
    },
]
