import "@js/bootstrap"
import "@sass/app.scss"
import "@plugins/css/plugins.scss"

import router from "@routes"
import store from "@stores"

import { createApp, computed } from "vue"
const app = createApp({})

app.config.errorHandler = function (err, vm, info) {
    console.error(err);
};

app.config.warnHandler = function (err, vm, trace) {
    console.error(err, trace);
};

app.use(router)
app.use(store)

import core from "./core"
core(app)

import components from "@js/components"
components(app)

app.mount("#root")
