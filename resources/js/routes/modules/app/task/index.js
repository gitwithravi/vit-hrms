import task from "./task"

export default [
    {
        path: "task",
        name: "Task",
        redirect: { name: "TaskList" },
        meta: {
            label: "task.task",
            icon: "fas fa-list-check",
            permissions: ["task:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
    },
    {
        path: "tasks",
        name: "Tasks",
        redirect: { name: "TaskList" },
        meta: {
            isNotNav: true,
            label: "task.tasks",
            icon: "fas fa-list-check",
            permissions: ["task:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [...task],
    },
]
