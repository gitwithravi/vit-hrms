import config from "./config"

export default [
    {
        path: "teams",
        name: "Team",
        redirect: { name: "TeamList" },
        meta: {
            label: "team.team",
            icon: "fas fa-user-friends",
            isNotNav: true,
            hideChildren: true,
            permissions: ["team:manage"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "TeamList",
                meta: {
                    trans: "global.list",
                    label: "team.team",
                },
                component: () => import("@views/Pages/Team/Index.vue"),
            },
            {
                path: ":uuid",
                name: "TeamShow",
                meta: {
                    trans: "global.detail",
                    label: "team.team",
                },
                component: () => import("@views/Pages/Team/Show.vue"),
            },
            {
                path: ":uuid/config",
                name: "TeamConfig",
                redirect: { name: "TeamConfigRole" },
                meta: {
                    label: "team.team",
                    icon: "fas fa-cog",
                    hideChildren: true,
                    permissions: ["team:manage"],
                },
                component: () => import("@views/Pages/Team/Config/Index.vue"),
                children: [...config],
            },
        ],
    },
]
