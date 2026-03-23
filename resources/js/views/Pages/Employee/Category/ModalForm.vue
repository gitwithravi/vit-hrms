<script setup>
import {computed, reactive, ref, watch} from "vue";
  import { useStore } from "vuex";
  import {useToast} from "vue-toastification";

  const store = useStore();
  const toast = useToast()
  const emit = defineEmits(["refresh"])

  const categoryOptions = reactive([
    {label: "Employee", value: "employee"},
    {label: "Staff", value: "staff"},
  ]);

  const category = ref('');
  const formSubmit = ref(false);

  const showModal = computed(function () {
    return store.getters['employee/category/getShowFormModal'];
  });
  const selectedEmployee = computed(function () {
    return store.getters['employee/category/getSelectedEmployee'];
  });

  const resetForm = () => {
    category.value = '';
    selectedEmployee.value = {};
    formSubmit.value = false;
  }

  const formData = computed(() => {
    return {
      category: category.value,
      id: selectedEmployee.value.id,
    };
  })

  const hideFormModal = () => {
    store.dispatch('employee/category/updateShowFormModal', false)
    resetForm()
  }

  watch(selectedEmployee, (newValue) => {
    category.value = newValue.category??''
  })

  const submitForm = async () => {
    formSubmit.value = true
    if (!category.value || category.value === '') {
      toast.info("Please select the category.")
      formSubmit.value = false
      return
    }
    try {
      await store.dispatch('employee/category/updateEmployeeCategory', {
        id: selectedEmployee.value.id,
        data: formData.value,
      })
      emit('refresh')
      hideFormModal()
      resetForm()
    } catch (e) {
      formSubmit.value = false
    }
  }
</script>

<template>
  <div class="w-[100vw] h-[100vh] absolute top-0 left-0 z-40" :class="!showModal ? 'hidden' : 'block'">
    <div tabindex="-1" aria-hidden="true" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-[#111827df] dark:bg-[#efefefdf]">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-900">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Attach Category to Employee
            </h3>
            <button type="button" @click="hideFormModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close</span>
            </button>
          </div>
          <div class="p-4 md:p-5 space-y-4">
            <form method="post">
              <label for="category_options" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Category for {{selectedEmployee.name}}</label>
              <select v-model="category" id="category_options" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select Employee Category</option>
                <template v-for="item in categoryOptions" v-model="category">
                  <option :value="item.value">{{item.label}}</option>
                </template>
              </select>
            </form>
          </div>
          <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button :disabled="formSubmit" @click="submitForm" type="button" :class="formSubmit?'bg-blue-400':'bg-blue-700'" class="text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <span v-if="!formSubmit">&nbsp;&nbsp;Save&nbsp;&nbsp;</span>
              <span v-else>Saving...</span>
            </button>
            <button :disabled="formSubmit" @click="hideFormModal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"> Close </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
