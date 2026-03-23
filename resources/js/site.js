import { Livewire, Alpine } from "@vendor/livewire/livewire/dist/livewire.esm"
import Clipboard from "@ryangjchandler/alpine-clipboard"
import AOS from "aos"
import Swiper from "swiper/bundle"

import "@sass/site.scss"
import "@plugins/css/aos.scss"
import "@plugins/css/swiper.scss"
import "@plugins/js/frostui.js"

Alpine.plugin(Clipboard)

Livewire.start()

AOS.init()

const pageUrl = window.location.href.split(/[?#]/)[0]
const menuLinks = Array.from(document.querySelectorAll("#navbar .navbar-nav a"))

menuLinks.forEach((link) => {
    if (link.href === pageUrl) {
        link.classList.add("active")

        const parentMenu = link.parentElement.parentElement.parentElement
        if (parentMenu?.classList.contains("nav-item")) {
            const dropdownElement = parentMenu.querySelector(
                '[data-fc-type="dropdown"]'
            )
            dropdownElement?.classList.add("active")

            const collapseElement = parentMenu.querySelector(
                '[data-fc-type="collapse"]'
            )
            collapseElement?.classList.add("active")
            if (collapseElement) {
                const collapse =
                    frost.Collapse.getInstanceOrCreate(collapseElement)
                collapse.show()
                if (parentCollapse) {
                    parentCollapse.style.height = null
                }
            }
        }

        const parentParentMenu =
            link.parentElement.parentElement.parentElement.parentElement
                .parentElement
        if (parentParentMenu?.classList.contains("nav-item")) {
            const dropdownElement = parentParentMenu.querySelector(
                '[data-fc-type="dropdown"]'
            )
            dropdownElement?.classList.add("active")
        }
    }
})

window.addEventListener("scroll", (ev) => {
    ev.preventDefault()
    const navbar = document.getElementById("navbar")
    if (navbar) {
        if (
            document.body.scrollTop >= 75 ||
            document.documentElement.scrollTop >= 75
        ) {
            navbar.classList.add("nav-sticky")
        } else {
            navbar.classList.remove("nav-sticky")
        }
    }
})

const btnComponent = document.querySelector('[data-toggle="back-to-top"]')

window.addEventListener("scroll", function () {
    if (window.pageYOffset > 72) {
        btnComponent.classList.add("flex")
        btnComponent.classList.remove("hidden")
    } else {
        btnComponent.classList.remove("flex")
        btnComponent.classList.add("hidden")
    }
})

if (btnComponent) {
    btnComponent.addEventListener("click", function (e) {
        e.preventDefault()
        window.scrollTo({ top: 0, behavior: "smooth" })
    })
}
