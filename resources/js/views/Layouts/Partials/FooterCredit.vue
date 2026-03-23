<template>
    <div class="my-4">
        <p
            v-if="showVersionNumber || footerCredit"
            class="space-x-2 text-center text-sm dark:text-gray-400"
        >
            <span v-if="showVersionNumber">{{
                $trans("general.version_info", { attribute: version })
            }}</span>
            <span v-if="footerCredit">{{ footerCredit }}</span>
        </p>
    </div>
</template>

<script>
export default {
    name: "FooterCredit",
}
</script>

<script setup>
import { getConfig } from "@core/helpers/action"

const version = getConfig("system.version")
const showVersionNumber = getConfig("system.showVersionNumber")
const footerCredit = getConfig("system.footerCredit")
</script>
