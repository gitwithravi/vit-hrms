<template>
    <BaseDataView class="col-span-1 sm:col-span-4">
        <template #label>
            {{ $trans("general.tags") }}
            <i
                class="fas fa-edit cursor-pointer"
                v-if="task.isOwner && !showForm"
                @click="showForm = true"
            ></i>
        </template>

        <div class="space-x-1" v-if="!showForm">
            <BaseBadge design="primary" v-for="tag in task.tags || []">{{
                tag.name
            }}</BaseBadge>
        </div>
        <FormAction
            v-if="showForm"
            no-card
            no-data-fetch
            cancel-action
            action="updateTags"
            :keep-adding="false"
            :init-url="initUrl"
            :init-form="initForm"
            :form="form"
            :after-submit="afterSubmit"
            @cancelled="showForm = false"
        >
            <BaseSelectSearch
                tags
                v-if="fetchData.isLoaded"
                name="tags"
                :placeholder="
                    $trans('global.select', {
                        attribute: $trans('general.tag'),
                    })
                "
                v-model="form.tags"
                v-model:error="formErrors.tags"
                :init-search="fetchData.tags"
                search-action="tag/list"
            />
        </FormAction>
    </BaseDataView>
</template>

<script>
export default {
    name: "TaskTagList",
}
</script>

<script setup>
import { reactive, ref, watch, onMounted } from "vue"
import { useStore } from "vuex"
import { cloneDeep } from "@core/utils"
import { getFormErrors } from "@core/helpers/action"

const store = useStore()

const emit = defineEmits(["refresh"])

const props = defineProps({
    task: {
        type: Object,
        default() {
            return {}
        },
    },
})

const initForm = {
    tags: [],
}

const initUrl = "task/"
const formErrors = getFormErrors(initUrl)

const showForm = ref(false)
const form = reactive({ ...initForm })
const fetchData = reactive({
    tags: [],
    isLoaded: false,
})

const setForm = (tags) => {
    Object.assign(initForm, {
        tags: tags.map((tag) => tag.uuid),
    })
    Object.assign(form, cloneDeep(initForm))

    fetchData.tags = tags.map((tag) => tag.uuid)
    fetchData.isLoaded = true
}

const afterSubmit = () => {
    showForm.value = false
    emit("refresh")
}

watch(
    () => props.task.tags,
    (value) => {
        setForm(value)
    }
)

onMounted(() => {
    setForm(props.task?.tags || [])
})
</script>
