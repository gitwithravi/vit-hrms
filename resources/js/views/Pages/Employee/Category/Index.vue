<template>
  <ListItem :init-url="initUrl" @setItems="setItems">
    <template #header>
      <PageHeader
          :title="$trans('employee.category.label')"
          :navs="[{ label: $trans('employee.employee'), path: 'EmployeeCategoryList' }]"
      >
        <PageHeaderAction
            url="employee-category"
            name="EmployeeCategoryList"
            :title="$trans('employee.employee-category')"
            :actions="userActions"
            @toggleFilter="showFilter = !showFilter"
        >
          <BaseButton
              v-if="perform('employee-category:edit')"
              design="white"
              @click="showAssignCategoryModal"
          >
            Assign Category
          </BaseButton>
        </PageHeaderAction>
      </PageHeader>
    </template>

    <template #filter>
      <ParentTransition appear :visibility="showFilter">
        <FilterForm
            @refresh="emitter.emit('listItems')"
            @hide="showFilter = false"
        ></FilterForm>
      </ParentTransition>
    </template>

    <ParentTransition appear :visibility="true">
      <DataTable
          :header="employees.headers"
          :meta="employees.meta"
          module="employee-category"
          @refresh="emitter.emit('listItems')"
      >
        <DataRow
            v-for="employee in employees.data"
            :key="employee.uuid"
        >
          <DataCell name="codeNumber">
            {{ employee.codeNumber }}
          </DataCell>
          <DataCell name="name">
            {{ employee.name }}
          </DataCell>
          <DataCell name="department">
            {{ employee.department }}
          </DataCell>
          <DataCell name="designation">
            {{ employee.designation }}
          </DataCell>
          <DataCell name="categoryName">
            {{ employee.categoryName??'--' }}
          </DataCell>
          <DataCell name="action">
            <FloatingMenu>
              <FloatingMenuItem
                  v-if="perform('employee-category:edit')"
                  icon="fas fa-edit"
                  @click="showEditModal(employee)"
              >
                {{ $trans("general.edit") }}
              </FloatingMenuItem>

            </FloatingMenu>
          </DataCell>
        </DataRow>
      </DataTable>
    </ParentTransition>
  </ListItem>
  <ModalForm @refresh="emitter.emit('listItems')"/>
  <AssignCategoryModal @refresh="emitter.emit('listItems')"/>
</template>

<script>
export default {
  name: "EmployeeCategoryList",
}
</script>

<script setup>
import { ref, reactive, inject } from "vue"
import { useRouter } from "vue-router"
import { perform } from "@core/helpers/action"
import FilterForm from "./Filter.vue"
import ModalForm from "./ModalForm.vue"
import AssignCategoryModal from "./AssignCategoryModal.vue"
import { useStore } from "vuex"

const router = useRouter()
const store = useStore();

const emitter = inject("emitter")

let userActions = ["filter"]

let dropdownActions = [];


const initUrl = "employee/category/"
const showFilter = ref(false)

const employees = reactive({})

const setItems = (data) => {
  Object.assign(employees, data)
}

const showEditModal = (employee) => {
  store.dispatch('employee/category/updateShowFormModal', true)
  store.dispatch('employee/category/updateSelectedEmployee', employee)
}

const showAssignCategoryModal = () => {
  store.dispatch('employee/category/updateShowAssignModal', true)
}

</script>
