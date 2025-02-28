<template>
    <Dialog v-model:visible="showModal" :header="editMode ? 'Editar Zona' : 'Nueva Zona'" :modal="true">
      <div class="p-4">
        <label class="block font-semibold mb-2">Nombre de la Zona</label>
        <InputText v-model="newZoneName" class="w-full p-2 border rounded" />
        <small v-if="errorMessage" class="text-red-500">{{ errorMessage }}</small>
      </div>
      <template #footer>
        <Button label="Cancelar" class="p-button-text" @click="closeModal" />
  <Button 
      :label="editMode ? 'Actualizar' : 'Guardar'" 
      class="p-button-primary" 
      @click="saveZone"
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
    zone: Object,
    visible: Boolean
  });
  
  const showModal = ref(props.visible);
  const newZoneName = ref(props.zone ? props.zone.name : "");
  const errorMessage = ref("");
  const editMode = ref(!!props.zone);
  const zoneId = ref(props.zone ? props.zone.id : null);
  
  watch(() => props.visible, (val) => {
    showModal.value = val;
  });
  
  function closeModal() {
    showModal.value = false;
    emit("closeCreateModal");
  }
  
  async function saveZone() {
    if (!newZoneName.value) {
        errorMessage.value = "El nombre de la zona es obligatorio";
        return;
    }
    if (editMode.value) {
        emit("update", zoneId.value, { name: newZoneName.value });
    } else {
        emit("save", { name: newZoneName.value });
    }
    closeModal();
} 
  
  </script>