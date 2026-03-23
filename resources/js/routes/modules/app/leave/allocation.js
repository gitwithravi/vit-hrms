export default [
    {
        path: "allocations",
        name: "LeaveAllocation",
        redirect: { name: "LeaveAllocationList" },
        meta: {
            label: "leave.allocation.allocation",
            icon: "fas fa-user-edit",
            hideChildren: true,
            permissions: ["leave-allocation:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "LeaveAllocationList",
                meta: {
                    trans: "global.list",
                    label: "leave.allocation.allocations",
                },
                component: () =>
                    import("@views/Pages/Leave/Allocation/Index.vue"),
            },
            {
                path: "create",
                name: "LeaveAllocationCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "leave.allocation.allocation",
                    permissions: ["leave-allocation:create"],
                },
                component: () =>
                    import("@views/Pages/Leave/Allocation/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "LeaveAllocationEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "leave.allocation.allocation",
                    permissions: ["leave-allocation:edit"],
                },
                component: () =>
                    import("@views/Pages/Leave/Allocation/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "LeaveAllocationDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "leave.allocation.allocation",
                    permissions: ["leave-allocation:create"],
                },
                component: () =>
                    import("@views/Pages/Leave/Allocation/Action.vue"),
            },
            {
                path: ":uuid",
                name: "LeaveAllocationShow",
                meta: {
                    trans: "global.detail",
                    label: "leave.allocation.allocation",
                },
                component: () =>
                    import("@views/Pages/Leave/Allocation/Show.vue"),
            },
        ],
    },
]
