export default [
    {
        path: "devices",
        name: "Device",
        redirect: { name: "DeviceList" },
        meta: {
            isNotNav: true,
            label: "device.device",
            icon: "fas fa-microchip",
            hideChildren: true,
            roles: ["admin"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "DeviceList",
                meta: {
                    trans: "global.list",
                    label: "device.devices",
                },
                component: () => import("@views/Pages/Device/Index.vue"),
            },
            {
                path: "create",
                name: "DeviceCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "device.device",
                },
                component: () => import("@views/Pages/Device/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "DeviceEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "device.device",
                },
                component: () => import("@views/Pages/Device/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "DeviceDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "device.device",
                },
                component: () => import("@views/Pages/Device/Action.vue"),
            },
            {
                path: ":uuid",
                name: "DeviceShow",
                meta: {
                    trans: "global.detail",
                    label: "device.device",
                },
                component: () => import("@views/Pages/Device/Show.vue"),
            },
        ],
    },
]
