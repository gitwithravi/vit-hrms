import { trans } from "@core/helpers/trans"
import { getOptionRoutes } from "../option"
import checklist from "./checklist"
import member from "./member"
import media from "./media"
import repeat from "./repeat"

export default [
    {
        path: "",
        name: "TaskList",
        meta: {
            label: "task.tasks",
            icon: "fas fa-chevron-right",
            permissions: ["task:read"],
        },
        component: () => import("@views/Pages/Task/Index.vue"),
    },
    {
        path: "dashboard",
        name: "TaskDashboard",
        meta: {
            noPadding: true,
            label: "task.dashboard.dashboard",
            icon: "fas fa-home",
            permissions: ["task:read"],
        },
        component: () => import("@views/Pages/Task/Dashboard/Index.vue"),
    },
    {
        path: "config",
        name: "TaskConfig",
        redirect: { name: "TaskConfigGeneral" },
        meta: {
            isNotNav: true,
            type: "config",
            action: "config",
            trans: "global.config",
            label: "config.config",
            permissions: ["task:config"],
        },
        component: () => import("@views/Pages/Task/Config/Index.vue"),
        children: [
            {
                path: "",
                name: "TaskConfigIndex",
                redirect: { name: "TaskConfigGeneral" },
            },
            {
                path: "general",
                name: "TaskConfigGeneral",
                meta: {
                    type: "config",
                    action: "config",
                    trans: "config.config",
                    label: "config.config",
                },
                component: () => import("@views/Pages/Task/Config/General.vue"),
            },
            getOptionRoutes({
                path: "categories",
                prefix: "TaskConfigCategory",
                queryType: "task_category",
                label: "task.category.category",
                transKey: "task.category",
                navs: [
                    { label: trans("task.task"), path: "TaskList" },
                    { label: trans("task.config.config"), path: "TaskConfig" },
                ],
            }),
            getOptionRoutes({
                path: "priorities",
                prefix: "TaskConfigPriority",
                queryType: "task_priority",
                label: "task.priority.priority",
                transKey: "task.priority",
                navs: [
                    { label: trans("task.task"), path: "TaskList" },
                    { label: trans("task.config.config"), path: "TaskConfig" },
                ],
            }),
            getOptionRoutes({
                path: "lists",
                prefix: "TaskConfigList",
                queryType: "task_list",
                label: "task.list.list",
                transKey: "task.list",
                navs: [
                    { label: trans("task.task"), path: "TaskList" },
                    { label: trans("task.config.config"), path: "TaskConfig" },
                ],
            }),
        ],
    },
    {
        path: "create",
        name: "TaskCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "task.task",
        },
        component: () => import("@views/Pages/Task/Action.vue"),
    },
    {
        path: ":uuid/edit",
        name: "TaskEdit",
        meta: {
            type: "edit",
            action: "update",
            trans: "global.edit",
            label: "task.task",
            permissions: ["task:edit"],
        },
        component: () => import("@views/Pages/Task/Action.vue"),
    },
    {
        path: ":uuid/duplicate",
        name: "TaskDuplicate",
        meta: {
            type: "duplicate",
            action: "create",
            trans: "global.duplicate",
            label: "task.task",
            permissions: ["task:create"],
        },
        component: () => import("@views/Pages/Task/Action.vue"),
    },
    {
        path: ":uuid",
        name: "TaskShow",
        redirect: { name: "TaskShowGeneral" },
        meta: {
            trans: "global.detail",
            label: "task.task",
            permissions: ["task:read"],
        },
        component: () => import("@views/Pages/Task/Show.vue"),
        children: [
            {
                path: "",
                name: "TaskShowIndex",
                redirect: { name: "TaskShowGeneral" },
            },
            {
                path: "general",
                name: "TaskShowGeneral",
                meta: {
                    type: "read",
                    action: "read",
                    trans: "general.general",
                    label: "general.general",
                },
                component: () => import("@views/Pages/Task/General.vue"),
            },
            {
                path: "checklists",
                name: "TaskChecklist",
                redirect: { name: "TaskChecklistList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...checklist],
            },
            {
                path: "members",
                name: "TaskMember",
                redirect: { name: "TaskMemberList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...member],
            },
            {
                path: "media",
                name: "TaskMedia",
                redirect: { name: "TaskMediaList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...media],
            },
            {
                path: "repeats",
                name: "TaskRepeat",
                redirect: { name: "TaskRepeatList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...repeat],
            },
        ],
    },
]
