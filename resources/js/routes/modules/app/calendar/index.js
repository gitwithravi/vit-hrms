import holiday from "./holiday"

export default [
    {
        path: "calendar",
        name: "Calendar",
        redirect: { name: "CalendarHoliday" },
        meta: {
            label: "calendar.calendar",
            icon: "fas fa-calendar",
            permissions: ["holiday:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [...holiday],
    },
]
