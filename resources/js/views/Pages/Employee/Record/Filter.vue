<template>
    <FilterForm :init-form="initForm" :form="form" @hide="emit('hide')">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-1"></div>
        </div>
    </FilterForm>
</template>

<script setup>
import { reactive } from "vue"

const emit = defineEmits(["hide"])

const initForm = {
    //
}

const form = reactive({ ...initForm })
</script>
