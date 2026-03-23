import store from "@stores"

export default [
    {
        path: "product",
        name: "Product",
        meta: {
            isNotNav: true,
            title: "setup.product",
            roles: ["admin"],
        },
        component: () => import("@views/Pages/Product/Index.vue"),
    },
    {
        path: "license",
        name: "License",
        meta: {
            isNotNav: true,
            title: "setup.license.validation",
        },
        component: () => import("@views/Pages/Product/License.vue"),
        beforeEnter: (to, from, next) => {
            if (getConfig("system.ac") == true) {
                next("/")
            } else {
                next()
            }
        },
    },
]

function getConfig(key) {
    return store.getters["config/config"](key)
}
