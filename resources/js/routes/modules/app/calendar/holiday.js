export default [
    {
        path: "holidays",
        name: "CalendarHoliday",
        redirect: { name: "CalendarHolidayList" },
        meta: {
            label: "calendar.holiday.holiday",
            icon: "fas fa-plane",
            hideChildren: true,
            permissions: ["holiday:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [
            {
                path: "",
                name: "CalendarHolidayList",
                meta: {
                    trans: "global.list",
                    label: "calendar.holiday.holidays",
                },
                component: () =>
                    import("@views/Pages/Calendar/Holiday/Index.vue"),
            },
            {
                path: "create",
                name: "CalendarHolidayCreate",
                meta: {
                    type: "create",
                    action: "create",
                    trans: "global.add",
                    label: "calendar.holiday.holiday",
                    permissions: ["holiday:create"],
                },
                component: () =>
                    import("@views/Pages/Calendar/Holiday/Action.vue"),
            },
            {
                path: ":uuid/edit",
                name: "CalendarHolidayEdit",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "calendar.holiday.holiday",
                    permissions: ["holiday:edit"],
                },
                component: () =>
                    import("@views/Pages/Calendar/Holiday/Action.vue"),
            },
            {
                path: ":uuid/duplicate",
                name: "CalendarHolidayDuplicate",
                meta: {
                    type: "duplicate",
                    action: "create",
                    trans: "global.duplicate",
                    label: "calendar.holiday.holiday",
                    permissions: ["holiday:create"],
                },
                component: () =>
                    import("@views/Pages/Calendar/Holiday/Action.vue"),
            },
            {
                path: ":uuid",
                name: "CalendarHolidayShow",
                meta: {
                    trans: "global.detail",
                    label: "calendar.holiday.holiday",
                },
                component: () =>
                    import("@views/Pages/Calendar/Holiday/Show.vue"),
            },
        ],
    },
]
