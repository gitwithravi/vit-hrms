import role from "./role"
import permission from "./permission"

export default [
    ...role,
    ...permission,
    {
        path: "dfa",
        name: "TeamConfigDfaList",
        meta: {
            trans: "team.config.dfa.dfa",
            label: "team.config.dfa.dfa",
        },
        component: () => import("@views/Pages/Team/Config/DFA/Index.vue"),
    },
]
