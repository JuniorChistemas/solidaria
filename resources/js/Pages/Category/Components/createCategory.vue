<template>
  <Dialog v-model:visible="showModal" :header="editMode ? 'Editar Categoría' : 'Nueva Categoría'" :modal="true">
    <div class="p-4">
      <!-- Campo para el nombre de la categoría -->
      <label class="block font-semibold mb-2">Nombre de la Categoría</label>
      <InputText v-model="newCategoryName" class="w-full p-2 border rounded" />
      <small v-if="errorMessage" class="text-red-500">{{ errorMessage }}</small>

      <!-- Selector de Estado (Solo cuando se edita) -->
      <div v-if="editMode" class="mt-4">
        <label class="block font-semibold mb-2">Estado</label>
        <Dropdown 
          v-model="newCategoryState" 
          :options="stateOptions" 
          optionLabel="label" 
          optionValue="value"
          class="w-full p-2 border rounded"
        />
      </div>
    </div>

    <template #footer>
      <Button label="Cancelar" class="p-button-text" @click="closeModal" />
      <Button 
        :label="editMode ? 'Actualizar' : 'Guardar'" 
        class="p-button-primary" 
        @click="saveCategory"
      />
    </template>
  </Dialog>
</template>

<script setup>
import { ref, watch, defineEmits, defineProps } from "vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";

const emit = defineEmits(["update", "save", "closeCreateModal"]);

const props = defineProps({
  category: Object,
  visible: Boolean
});

const showModal = ref(props.visible);
const newCategoryName = ref("");
const newCategoryState = ref("Activo"); // Estado por defecto
const errorMessage = ref("");
const editMode = ref(false);
const categoryId = ref(null);

// Opciones de estado en formato adecuado para PrimeVue Dropdown
const stateOptions = [
  { label: "Activo", value: "Activo" },
  { label: "Inactivo", value: "Inactivo" }
];

// Sincroniza visibilidad del modal
watch(() => props.visible, (val) => {
  showModal.value = val;
});

// Actualiza los valores cuando cambia la categoría seleccionada
watch(() => props.category, (newCategory) => {
  if (newCategory) {
    newCategoryName.value = newCategory.name || "";
    newCategoryState.value = newCategory.state || "Activo";
    editMode.value = true;
    categoryId.value = newCategory.id;
  } else {
    newCategoryName.value = "";
    newCategoryState.value = "Activo";
    editMode.value = false;
    categoryId.value = null;
  }
}, { immediate: true });

// Cierra el modal
function closeModal() {
  showModal.value = false;
  emit("closeCreateModal");
}

// Guarda o actualiza la categoría
async function saveCategory() {
  if (!newCategoryName.value.trim()) {
    errorMessage.value = "El nombre de la categoría es obligatorio";
    return;
  }

  const categoryData = {
    name: newCategoryName.value.trim(),
    state: newCategoryState.value
  };

  if (editMode.value) {
    emit("update", categoryId.value, categoryData);
  } else {
    emit("save", categoryData);
  }

  closeModal();
}

</script>
