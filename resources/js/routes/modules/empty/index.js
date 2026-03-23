import store from "@stores"

export default [
    {
        path: "team/selection",
        name: "TeamSelection",
        meta: {},
        component: () => import("@views/Pages/Team/Selection.vue"),
        beforeEnter: (to, from, next) => {
            if (store.getters["auth/user/currentTeamId"]) {
                if (to.query.ref) {
                    next(to.query.ref)
                } else {
                    next({ name: "Dashboard" })
                }
            } else {
                next()
            }
        },
    },
]
