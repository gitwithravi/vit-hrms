export default [
    {
        path: "",
        name: "TaskChecklistList",
        meta: {
            trans: "task.checklist.checklist",
            label: "task.checklist.checklist",
        },
        component: () => import("@views/Pages/Task/Checklist/Index.vue"),
    },
]
