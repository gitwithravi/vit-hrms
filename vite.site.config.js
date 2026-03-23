const path = require("path")
import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import viteCompression from "vite-plugin-compression"
import { resolve } from "path"

export default defineConfig(() => {
    console.log("\n =========== BUILDING SITE =========== ")

    return {
        plugins: [
            laravel({
                buildDirectory: "site/build",
                input: ["resources/js/site.js"],
                refresh: true,
            }),
            viteCompression({
                filter: /\.(js|css|scss)$/i,
            }),
        ],
        css: {
            postcss: "./vite/site/",
        },
        resolve: {
            alias: {
                "@": path.resolve(__dirname, "./resources"),
                "@sass": path.resolve(__dirname, "./resources/sass"),
                "@plugins": path.resolve(__dirname, "./resources/plugins"),
                "@js": path.resolve(__dirname, "./resources/js"),
                "@vendor": path.resolve(__dirname, "./vendor"),
            },
        },
    }
})
