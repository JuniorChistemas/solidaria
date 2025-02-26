<template>
    <DataTable
      :value="categoriesData"
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
              Categorías {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }}
          </span>
      </template>

      <template #header>
          <div class="flex justify-between gap-2">
              <div class="mr-auto flex items-center gap-2">
                  <InputText
                      id="search"
                      placeholder="Buscar"
                      type="text"
                      v-model="nameCategory"
                      class="w-32 sm:w-auto"
                      @input="handleSearchInput"
                  />
                  <Button 
                      v-if="nameCategory" 
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
                      @click="$emit('open-edit', slotProps.data)"
                  />
                  <Button
                      icon="pi pi-trash"
                      outlined
                      rounded
                      class="p-button-sm"
                      severity="danger"
                      tooltip="Eliminar"
                      @click="$emit('open-delete', slotProps.data)"
                  />
              </div>
          </template>
      </Column>

      <template #empty>
          <h3>No existen categorías registradas</h3>
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
import { debounce } from "lodash";

const props = defineProps({
  categoriesData: Array,
  pagination: Object,
  loadingTable: Boolean
});

const nameCategory = ref("");

const emit = defineEmits(["loadingPage", "searchCategory", "open-create", "open-edit", "open-delete"]);

function handleSearchInput(event) {
    const value = event.target.value;
    debounceSearchCategory(value);
}

const debounceSearchCategory = debounce((value) => {
    emit("searchCategory", value);
}, 400);

function nextPage(event) {
    emit("loadingPage", event.page + 1);
}

function clearSearch() {
    nameCategory.value = "";
    emit("searchCategory", "");
}
</script>
