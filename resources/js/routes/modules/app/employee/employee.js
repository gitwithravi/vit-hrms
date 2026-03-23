import record from "./record"
import workShift from "./workShift"
import qualification from "./qualification"
import account from "./account"
import document from "./document"
import experience from "./experience"
import { trans } from "@core/helpers/trans"
import { getOptionRoutes } from "../option"

export default [
    {
        path: "",
        name: "EmployeeList",
        meta: {
            label: "employee.employees",
            icon: "fas fa-chevron-right",
            permissions: ["employee:read"],
        },
        component: () => import("@views/Pages/Employee/Index.vue"),
    },
    {
        path: "config",
        name: "EmployeeConfig",
        redirect: { name: "EmployeeConfigGeneral" },
        meta: {
            isNotNav: true,
            type: "config",
            action: "config",
            trans: "global.config",
            label: "config.config",
            permissions: ["employee:config"],
        },
        component: () => import("@views/Pages/Employee/Config/Index.vue"),
        children: [
            {
                path: "",
                name: "EmployeeConfigIndex",
                redirect: { name: "EmployeeConfigGeneral" },
            },
            {
                path: "general",
                name: "EmployeeConfigGeneral",
                meta: {
                    type: "config",
                    action: "config",
                    trans: "config.config",
                    label: "config.config",
                },
                component: () =>
                    import("@views/Pages/Employee/Config/General.vue"),
            },
            getOptionRoutes({
                path: "employment-status",
                prefix: "EmployeeConfigEmploymentStatus",
                queryType: "employment_status",
                label: "employee.employment_status.employment_status",
                transKey: "employee.employment_status",
                navs: [
                    { label: trans("employee.employee"), path: "EmployeeList" },
                    {
                        label: trans("employee.config.config"),
                        path: "EmployeeConfig",
                    },
                ],
            }),
            getOptionRoutes({
                path: "employment-type",
                prefix: "EmployeeConfigEmploymentType",
                queryType: "employment_type",
                label: "employee.employment_type.employment_type",
                transKey: "employee.employment_type",
                navs: [
                    { label: trans("employee.employee"), path: "EmployeeList" },
                    {
                        label: trans("employee.config.config"),
                        path: "EmployeeConfig",
                    },
                ],
            }),
            getOptionRoutes({
                path: "qualification-level",
                prefix: "EmployeeConfigQualificationLevel",
                queryType: "qualification_level",
                label: "employee.qualification_level.qualification_level",
                transKey: "employee.qualification_level",
                navs: [
                    { label: trans("employee.employee"), path: "EmployeeList" },
                    {
                        label: trans("employee.config.config"),
                        path: "EmployeeConfig",
                    },
                ],
            }),
            getOptionRoutes({
                path: "document-type",
                prefix: "EmployeeConfigDocumentType",
                queryType: "document_type",
                label: "employee.document_type.document_type",
                transKey: "employee.document_type",
                navs: [
                    { label: trans("employee.employee"), path: "EmployeeList" },
                    {
                        label: trans("employee.config.config"),
                        path: "EmployeeConfig",
                    },
                ],
            }),
        ],
    },
    {
        path: "create",
        name: "EmployeeCreate",
        meta: {
            type: "create",
            action: "create",
            trans: "global.add",
            label: "employee.employee",
        },
        component: () => import("@views/Pages/Employee/Action.vue"),
    },
    {
        path: ":uuid",
        name: "EmployeeShow",
        redirect: { name: "EmployeeShowBasic" },
        meta: {
            trans: "global.detail",
            label: "employee.employee",
            permissions: ["employee:read"],
        },
        component: () => import("@views/Pages/Employee/Show.vue"),
        children: [
            {
                path: "",
                name: "EmployeeShowIndex",
                redirect: { name: "EmployeeShowBasic" },
            },
            {
                path: "basic",
                name: "EmployeeShowBasic",
                meta: {
                    type: "read",
                    action: "read",
                    trans: "general.basic",
                    label: "general.basic",
                },
                component: () => import("@views/Pages/Employee/Basic.vue"),
            },
            {
                path: "basic/edit",
                name: "EmployeeEditBasic",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "employee.employee",
                },
                component: () => import("@views/Pages/Employee/EditBasic.vue"),
            },
            {
                path: "photo/edit",
                name: "EmployeeEditPhoto",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "contact.props.photo",
                },
                component: () => import("@views/Pages/Employee/EditPhoto.vue"),
            },
            {
                path: "contact",
                name: "EmployeeShowContact",
                meta: {
                    type: "general",
                    action: "general",
                    trans: "contact.contact",
                    label: "contact.contact",
                },
                component: () => import("@views/Pages/Employee/Contact.vue"),
            },
            {
                path: "contact/edit",
                name: "EmployeeEditContact",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "contact.contact",
                },
                component: () =>
                    import("@views/Pages/Employee/EditContact.vue"),
            },
            {
                path: "login",
                name: "EmployeeShowLogin",
                meta: {
                    type: "general",
                    action: "general",
                    trans: "contact.login.login",
                    label: "contact.login.login",
                },
                component: () => import("@views/Pages/Employee/Login.vue"),
            },
            {
                path: "login/edit",
                name: "EmployeeEditLogin",
                meta: {
                    type: "edit",
                    action: "update",
                    trans: "global.edit",
                    label: "contact.login.login",
                },
                component: () => import("@views/Pages/Employee/EditLogin.vue"),
            },
            {
                path: "records",
                name: "EmployeeRecord",
                redirect: { name: "EmployeeRecordList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...record],
            },
            {
                path: "work-shifts",
                name: "EmployeeWorkShift",
                redirect: { name: "EmployeeWorkShiftList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...workShift],
            },
            {
                path: "qualifications",
                name: "EmployeeQualification",
                redirect: { name: "EmployeeQualificationList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...qualification],
            },
            {
                path: "accounts",
                name: "EmployeeAccount",
                redirect: { name: "EmployeeAccountList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...account],
            },
            {
                path: "documents",
                name: "EmployeeDocument",
                redirect: { name: "EmployeeDocumentList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...document],
            },
            {
                path: "experiences",
                name: "EmployeeExperience",
                redirect: { name: "EmployeeExperienceList" },
                meta: {},
                component: {
                    template: "<router-view></router-view>",
                },
                children: [...experience],
            },
        ],
    },
]
