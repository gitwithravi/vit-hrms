import GuestHeader from "@views/Layouts/Partials/GuestHeader.vue"
import PageHeader from "@views/Layouts/Partials/PageHeader.vue"
import PageHeaderAction from "@views/Layouts/Partials/PageHeaderAction.vue"
import ProfileDropdown from "@views/Layouts/Partials/ProfileDropdown.vue"
import AppNavigation from "@views/Layouts/Partials/AppNavigation.vue"
import MobileSidebar from "@views/Layouts/Partials/MobileSidebar.vue"
import FooterCredit from "@views/Layouts/Partials/FooterCredit.vue"
import ConfigPage from "@views/Layouts/Partials/ConfigPage.vue"
import ConfigSidebar from "@views/Layouts/Partials/ConfigSidebar.vue"
import ModuleConfig from "@views/Layouts/Partials/ModuleConfig.vue"
import ModuleConfigSidebar from "@views/Layouts/Partials/ModuleConfigSidebar.vue"
import FormActionButton from "@views/Layouts/Partials/FormActionButton.vue"
import ShowButton from "@views/Layouts/Partials/ShowButton.vue"
import CardHeader from "@views/Layouts/Partials/CardHeader.vue"
import ErrorPage from "@views/Layouts/Partials/ErrorPage.vue"
import ReLogin from "@views/Layouts/Partials/ReLogin.vue"
import KeySearch from "@views/Layouts/Partials/KeySearch.vue"

import ParentTransition from "./ParentTransition.vue"
import ChildTransition from "./ChildTransition.vue"
import MenuParentTransition from "./MenuParentTransition.vue"

import NameInput from "@js/components/App/NameInput.vue"
import AddressInput from "@js/components/App/AddressInput.vue"
import PaymentMethodInput from "@js/components/App/PaymentMethodInput.vue"
import PaymentMethodDetail from "@js/components/App/PaymentMethodDetail.vue"
import EmployeeSummary from "@js/components/App/EmployeeSummary.vue"
import TimesheetClock from "@js/components/App/TimesheetClock.vue"
import LedgerBalance from "@js/components/App/LedgerBalance.vue"

export default (app) => {
    app.component("GuestHeader", GuestHeader)
    app.component("PageHeader", PageHeader)
    app.component("PageHeaderAction", PageHeaderAction)
    app.component("ProfileDropdown", ProfileDropdown)
    app.component("AppNavigation", AppNavigation)
    app.component("MobileSidebar", MobileSidebar)
    app.component("FooterCredit", FooterCredit)
    app.component("ConfigPage", ConfigPage)
    app.component("ConfigSidebar", ConfigSidebar)
    app.component("ModuleConfig", ModuleConfig)
    app.component("ModuleConfigSidebar", ModuleConfigSidebar)
    app.component("FormActionButton", FormActionButton)
    app.component("ShowButton", ShowButton)
    app.component("CardHeader", CardHeader)
    app.component("ErrorPage", ErrorPage)
    app.component("ReLogin", ReLogin)
    app.component("KeySearch", KeySearch)

    app.component("ParentTransition", ParentTransition)
    app.component("ChildTransition", ChildTransition)
    app.component("MenuParentTransition", MenuParentTransition)

    app.component("NameInput", NameInput)
    app.component("AddressInput", AddressInput)
    app.component("PaymentMethodInput", PaymentMethodInput)
    app.component("PaymentMethodDetail", PaymentMethodDetail)
    app.component("EmployeeSummary", EmployeeSummary)
    app.component("TimesheetClock", TimesheetClock)
    app.component("LedgerBalance", LedgerBalance)
}
