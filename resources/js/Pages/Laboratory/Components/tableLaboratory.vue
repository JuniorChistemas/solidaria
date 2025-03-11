<template>     
    <DataTable       
      :value="laboratoriesData"       
      :lazy="true"       
      :paginator="true"       
      :rows="pagination.per_page"       
      :totalRecords="pagination.total"       
      @page="nextPage"       
      size="small"       
      scrollable       
      scroll-height="35rem"       
      data-key="id"       
      show-gridlines       
      :loading="loadingTable"     
    >       
      <template #paginatorstart>           
        <span>               
          Laboratorios {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }}           
        </span>       
      </template>        
      
      <template #header>           
        <div class="flex justify-between gap-2">               
          <div class="mr-auto flex items-center gap-2">                   
            <InputText                       
              id="search"                       
              placeholder="Buscar"                       
              type="text"                       
              v-model="nameLaboratory"                       
              class="w-32 sm:w-auto"                       
              @input="handleSearchInput"                   
            />                   
            <Button                        
              v-if="nameLaboratory"                        
              icon="pi pi-times"                        
              class="p-button-text p-button-sm"                       
              @click="clearSearch"                       
              title="Limpiar búsqueda"                   
            />               
          </div>               
          <div>                   
            <Button label="Nuevo" @click="$emit('open-create')" />               
          </div>           
        </div>       
      </template>        
      
      <Column header="№">           
        <template #body="slotProps">               
          <Badge :value="slotProps.data.id.toString()" severity="secondary" />           
        </template>       
      </Column>       
      <Column field="name" header="Nombre"></Column>
      <Column field="state" header="Estado">
        <template #body="slotProps">
          <Tag 
            :severity="slotProps.data.state ? 'success' : 'danger'" 
            :value="slotProps.data.state ? 'Activo' : 'Inactivo'" 
          />
        </template>
      </Column>
      <Column field="created_at" header="Fecha de Registro">
        <template #body="slotProps">
          {{ formatDate(slotProps.data.created_at) }}
        </template>
      </Column>
      <Column field="updated_at" header="Fecha de Modificación">
        <template #body="slotProps">
          {{ formatDate(slotProps.data.updated_at) }}
        </template>
      </Column>
      
      <!-- Acciones -->       
      <Column header="Acciones">           
        <template #body="slotProps">               
          <div class="flex gap-2">                   
            <Button                       
              icon="pi pi-pencil"                       
              outlined                       
              rounded                       
              class="p-button-sm"                       
              tooltip="Editar"                       
              @click="console.log('Editando:', slotProps.data); $emit('open-edit', slotProps.data)"                   
            />                   
            <Button                       
              icon="pi pi-trash"                       
              outlined                       
              rounded                       
              class="p-button-sm"                       
              severity="danger"                       
              tooltip="Eliminar"                       
              @click=" $emit('open-delete', slotProps.data)"                   
            />               
          </div>           
        </template>       
      </Column>        
      
      <template #empty>           
        <h3>No existen laboratorios registrados</h3>       
      </template>     
    </DataTable> 
  </template>  
  
  <script setup> 
  import { ref } from 'vue'; 
  import Badge from "primevue/badge"; 
  import Button from "primevue/button"; 
  import Column from "primevue/column"; 
  import DataTable from "primevue/datatable"; 
  import InputText from "primevue/inputtext";
  import Tag from "primevue/tag"; 
  import { debounce } from "lodash";  
  
  const props = defineProps({   
    laboratoriesData: Array,   
    pagination: Object,   
    loadingTable: Boolean 
  });  
  
  const nameLaboratory = ref("");  
  
  const emit = defineEmits([
    "loadingPage", 
    "searchLaboratory", 
    "open-create", 
    "open-edit", 
    "open-delete"
  ]);  
  
  function handleSearchInput(event) {     
    const value = event.target.value;     
    debounceSearchLaboratory(value); 
  }  
  
  const debounceSearchLaboratory = debounce((value) => {     
    emit("searchLaboratory", value); 
  }, 400);  
  
  function nextPage(event) {     
    emit("loadingPage", event.page + 1); 
  }  
  
  function clearSearch() {     
    nameLaboratory.value = "";     
    emit("searchLaboratory", ""); 
  } 
  
  function formatDate(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('es-ES', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }).format(date);
  }
  </script>