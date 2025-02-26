<template>
  <Dialog v-model:visible="showModal" :header="editMode ? 'Editar Categoría' : 'Nueva Categoría'" :modal="true">
    <div class="p-4">
      <label class="block font-semibold mb-2">Nombre de la Categoría</label>
      <InputText v-model="newCategoryName" class="w-full p-2 border rounded" />
      <small v-if="errorMessage" class="text-red-500">{{ errorMessage }}</small>
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
import { ref, watch, defineEmits } from "vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import axios from "axios";

const emit = defineEmits(["update","save", "refreshList", "closeCreateModal"]);

const props = defineProps({
  category: Object,
  visible: Boolean
});

const showModal = ref(props.visible);
const newCategoryName = ref(props.category ? props.category.name : "");
const errorMessage = ref("");
const editMode = ref(!!props.category);
const categoryId = ref(props.category ? props.category.id : null);

watch(() => props.visible, (val) => {
  showModal.value = val;
});

function closeModal() {
  showModal.value = false;
  emit("closeCreateModal");
}

async function saveCategory() {
    if (!newCategoryName.value) {
        errorMessage.value = "El nombre de la categoría es obligatorio";
        return;
    }
    if (editMode.value) {
        emit("update", categoryId.value, { name: newCategoryName.value });
    } else {
        emit("save", { name: newCategoryName.value }); 
    }
    closeModal(); 
}



</script>
