import leaveType from "./type"
import allocation from "./allocation"
import request from "./request"

export default [
    {
        path: "leave",
        name: "Leave",
        redirect: { name: "LeaveRequest" },
        meta: {
            label: "leave.leave",
            icon: "fas fa-sticky-note",
            permissions: ["leave-allocation:read", "leave-request:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            ...request,
            ...allocation,
            ...leaveType,
            {
                path: "config",
                name: "LeaveConfig",
                redirect: { name: "LeaveConfigGeneral" },
                meta: {
                    isNotNav: true,
                    type: "config",
                    icon: "fas fa-cog",
                    action: "config",
                    trans: "global.config",
                    label: "config.config",
                    permissions: ["leave:config"],
                },
                component: () => import("@views/Pages/Leave/Config/Index.vue"),
                children: [
                    {
                        path: "general",
                        name: "LeaveConfigGeneral",
                        meta: {
                            type: "config",
                            action: "config",
                            trans: "config.config",
                            label: "config.config",
                        },
                        component: () =>
                            import("@views/Pages/Leave/Config/General.vue"),
                    },
                ],
            },
        ],
    },
]
