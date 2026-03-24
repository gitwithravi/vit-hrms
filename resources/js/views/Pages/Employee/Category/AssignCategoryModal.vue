<script setup>
import { computed, ref, watch } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import * as Api from "@core/apis";

const store = useStore();
const toast = useToast();
const emit = defineEmits(["refresh"]);

const designations = ref([]);
const mappings = ref([]);
const loading = ref(false);
const formSubmit = ref(false);

const showModal = computed(() => {
    return store.getters["employee/category/getShowAssignModal"];
});

const hideModal = () => {
    store.dispatch("employee/category/updateShowAssignModal", false);
    formSubmit.value = false;
};

const fetchDesignations = async () => {
    loading.value = true;
    try {
        const response = await Api.custom({
            url: "/app/employee-category/pre-requisite",
            method: "GET",
        });
        designations.value = response.designations || [];
        mappings.value = designations.value.map((d) => ({
            designation: d.uuid,
            designation_name: d.name,
            category: "",
        }));
    } catch (e) {
        toast.error("Failed to load designations.");
    } finally {
        loading.value = false;
    }
};

watch(showModal, (val) => {
    if (val) {
        fetchDesignations();
    }
});

const setAllCategory = (category) => {
    mappings.value.forEach((m) => {
        m.category = category;
    });
};

const submitForm = async () => {
    const selected = mappings.value.filter((m) => m.category !== "");
    if (selected.length === 0) {
        toast.info("Please select a category for at least one designation.");
        return;
    }
    formSubmit.value = true;
    try {
        await store.dispatch("employee/category/bulkAssignCategory", {
            mappings: selected.map((m) => ({
                designation: m.designation,
                category: m.category,
            })),
        });
        emit("refresh");
        hideModal();
    } catch (e) {
        formSubmit.value = false;
    }
};
</script>

<template>
    <div
        class="w-[100vw] h-[100vh] absolute top-0 left-0 z-40"
        :class="!showModal ? 'hidden' : 'block'"
    >
        <div
            tabindex="-1"
            aria-hidden="true"
            class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-[#111827df] dark:bg-[#efefefdf]"
        >
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-900"
                >
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
                    >
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white"
                        >
                            Assign Category by Designation
                        </h3>
                        <button
                            type="button"
                            @click="hideModal"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <div v-if="loading" class="text-center py-4">
                            <span
                                class="text-gray-500 dark:text-gray-400"
                                >Loading designations...</span
                            >
                        </div>
                        <div v-else>
                            <div class="flex justify-end space-x-2 mb-3">
                                <button
                                    type="button"
                                    @click="setAllCategory('employee')"
                                    class="text-xs px-3 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:hover:bg-blue-800"
                                >
                                    Set All Employee
                                </button>
                                <button
                                    type="button"
                                    @click="setAllCategory('staff')"
                                    class="text-xs px-3 py-1 rounded bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900 dark:text-green-300 dark:hover:bg-green-800"
                                >
                                    Set All Staff
                                </button>
                                <button
                                    type="button"
                                    @click="setAllCategory('')"
                                    class="text-xs px-3 py-1 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                >
                                    Clear All
                                </button>
                            </div>
                            <div
                                class="max-h-96 overflow-y-auto border rounded-lg dark:border-gray-600"
                            >
                                <table
                                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                                >
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0"
                                    >
                                        <tr>
                                            <th
                                                scope="col"
                                                class="px-4 py-3"
                                            >
                                                Designation
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3"
                                            >
                                                Category
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="mapping in mappings"
                                            :key="mapping.designation"
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        >
                                            <td
                                                class="px-4 py-2 font-medium text-gray-900 dark:text-white"
                                            >
                                                {{
                                                    mapping.designation_name
                                                }}
                                            </td>
                                            <td class="px-4 py-2">
                                                <select
                                                    v-model="
                                                        mapping.category
                                                    "
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                >
                                                    <option value="">
                                                        -- Select --
                                                    </option>
                                                    <option value="employee">
                                                        Employee
                                                    </option>
                                                    <option value="staff">
                                                        Staff
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr v-if="mappings.length === 0">
                                            <td
                                                colspan="2"
                                                class="px-4 py-4 text-center text-gray-400"
                                            >
                                                No designations found.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600"
                    >
                        <button
                            :disabled="formSubmit"
                            @click="submitForm"
                            type="button"
                            :class="
                                formSubmit
                                    ? 'bg-blue-400'
                                    : 'bg-blue-700'
                            "
                            class="text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            <span v-if="!formSubmit"
                                >&nbsp;&nbsp;Save&nbsp;&nbsp;</span
                            >
                            <span v-else>Saving...</span>
                        </button>
                        <button
                            :disabled="formSubmit"
                            @click="hideModal"
                            type="button"
                            class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
