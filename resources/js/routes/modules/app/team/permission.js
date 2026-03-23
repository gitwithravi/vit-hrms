export default [
    {
        path: "permission",
        name: "TeamConfigPermission",
        redirect: { name: "TeamConfigPermissionAssign" },
        meta: {
            label: "team.config.permission.permission",
            icon: "fas fa-key",
            key: "permission",
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "TeamConfigPermissionAssign",
                meta: {
                    trans: "global.assign",
                    label: "team.config.permission.permission",
                },
                component: () =>
                    import("@views/Pages/Team/Config/Permission/Index.vue"),
            },
            {
                path: ":module",
                name: "TeamConfigPermissionAssignModule",
                meta: {
                    trans: "global.assign",
                    label: "team.config.permission.permission",
                },
                component: () =>
                    import("@views/Pages/Team/Config/Permission/Index.vue"),
            },
        ],
    },
    {
        path: "user-permission",
        name: "TeamConfigUserPermission",
        meta: {
            isNotNav: true,
            label: "team.config.permission.user_permission",
            icon: "fas fa-key",
            key: "user-permission",
        },
        component: () => import("@views/Pages/Team/Config/Permission/User.vue"),
    },
]
