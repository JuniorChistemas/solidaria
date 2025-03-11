<template>
  <Dialog v-model:visible="showModal" :header="editMode ? 'Editar Laboratorio' : 'Nuevo Laboratorio'" :modal="true">
    <div class="p-4">
      <label class="block font-semibold mb-2">Nombre del Laboratorio</label>
      <InputText v-model="newLaboratoryName" class="w-full p-2 border rounded" />
      
      <div class="mt-4">
        <label class="block font-semibold mb-2">Estado</label>
        <Dropdown
          v-model="laboratoryState"
          :options="stateOptions"
          optionLabel="label"
          optionValue="value"
          placeholder="Seleccionar estado"
          class="w-full"
        />
      </div>
      
      <small v-if="errorMessage" class="text-red-500">{{ errorMessage }}</small>
    </div>
    <template #footer>
      <Button label="Cancelar" class="p-button-text" @click="closeModal" />
      <Button 
        :label="editMode ? 'Actualizar' : 'Guardar'" 
        class="p-button-primary" 
        @click="saveLaboratory"
      />
    </template>
  </Dialog>
</template>

<script setup>
import { ref, watch, defineEmits } from "vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import axios from "axios";

const emit = defineEmits(["update", "save", "refreshList", "closeCreateModal"]);

const props = defineProps({
  laboratory: Object,
  visible: Boolean
});

const showModal = ref(props.visible);
const newLaboratoryName = ref(props.laboratory ? props.laboratory.name : "");
const laboratoryState = ref(props.laboratory ? props.laboratory.state : true);
const errorMessage = ref("");
const editMode = ref(!!props.laboratory);
const laboratoryId = ref(props.laboratory ? props.laboratory.id : null);

const stateOptions = [
  { label: "Activo", value: true },
  { label: "Inactivo", value: false }
];

watch(() => props.visible, (val) => {
  showModal.value = val;
});

watch(() => props.laboratory, (val) => {
  if (val) {
    newLaboratoryName.value = val.name;
    laboratoryState.value = Boolean(val.state);
    laboratoryId.value = val.id;
    editMode.value = true;
  } else {
    newLaboratoryName.value = "";
    laboratoryState.value = true;
    laboratoryId.value = null;
    editMode.value = false;
  }
}, { immediate: true });

function closeModal() {
  showModal.value = false;
  emit("closeCreateModal");
}

async function saveLaboratory() {
  if (!newLaboratoryName.value) {
    errorMessage.value = "El nombre del laboratorio es obligatorio";
    return;
  }
  
  const laboratoryData = {
    name: newLaboratoryName.value,
    state: laboratoryState.value
  };
  
  if (editMode.value) {
    emit("update", laboratoryId.value, laboratoryData);
  } else {
    emit("save", laboratoryData); 
  }
  closeModal(); 
}
</script>