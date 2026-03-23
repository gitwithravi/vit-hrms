export default [
    {
        path: "role",
        name: "TeamConfigRole",
        redirect: { name: "TeamConfigRoleList" },
        meta: {
            label: "team.config.role.role",
            icon: "fas fa-user-tag",
            hideChildren: true,
            key: "role",
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "TeamConfigRoleList",
                meta: {
                    trans: "global.list",
                    label: "team.config.role.role",
                },
                component: () =>
                    import("@views/Pages/Team/Config/Role/Index.vue"),
            },
            {
                path: "create",
                name: "TeamConfigRoleCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "team.config.role.role",
                },
                component: () =>
                    import("@views/Pages/Team/Config/Role/Action.vue"),
            },
        ],
    },
]
