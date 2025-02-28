<template>
    <DataTable
      :value="zonesDataComputed"
      :lazy="true"
      :paginator="true"
      :rows="pagination.per_page"
      :totalRecords="pagination.total"
      @page="nextPage"
      @sort="handleSort"
      size="small"
      scrollable
      scroll-height="35rem"
      data-key="id"
      show-gridlines
      :loading="loadingTable"
      v-model:sortField="sortField"
      v-model:sortOrder="sortOrder"
    >
      <template #paginatorstart>
          <span>
              Zonas {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }}
          </span>
      </template>

      <template #header>
    <div class="flex flex-col sm:flex-row justify-between items-center p-3">
        <!-- 🔹 Sección del título y contador -->
        <div class="flex items-center gap-2">
            <h3 class="text-lg font-bold">Zonas:</h3>
            <span class="px-3 py-1 text-white rounded-full text-sm" 
                  style="background-color: #1abc9c;">
                {{ props.zonesData.length }}
            </span>
        </div>

        <!-- 🔹 Botón "Agregar Nueva Zona" -->
        <Button label="+ Agregar Nueva Zona" class="text-white" 
                style="background-color: #1abc9c;"
                @click="$emit('open-create')" />
    </div>
              <!-- 🔹 Buscador en la esquina derecha debajo del botón -->
    <div class="flex justify-end mt-2">
        <InputText
            id="search"
            placeholder="Buscar zona..."
            type="text"
            v-model="nameZone"
            class="w-48 sm:w-64 p-2 border rounded"
            @input="handleSearchInput"
        />
        <Button 
            v-if="nameZone" 
            icon="pi pi-times" 
            class="p-button-text p-button-sm"
            @click="clearSearch"
            title="Limpiar búsqueda"
        />
    </div>
      </template>

      <Column header="Código">
          <template #body="slotProps">
              <Badge :value="slotProps.data.id.toString()" severity="secondary" />
          </template>
      </Column>
      <Column field="name" header="Zona" sortable></Column>
      <Column field="created_at" header="Fecha de Registro" sortable></Column>
      <Column field="updated_at" header="Fecha de Modificación" sortable></Column>

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
                      @click="$emit('open-delete', slotProps.data)"
                  />
              </div>
          </template>
      </Column>

      <template #empty>
          <h3>No existen zonas registradas</h3>
      </template>
    </DataTable>
</template>

<script setup>
import { ref, computed } from "vue";
import Badge from "primevue/badge";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import { debounce } from "lodash";

const props = defineProps({
  zonesData: Array,
  pagination: Object,
  loadingTable: Boolean
});
const sortField = ref(null);
const sortOrder = ref(null);
const nameZone = ref("");

const emit = defineEmits(["loadingPage", "searchZone", "open-create", "open-edit", "open-delete"]);

function handleSearchInput(event) {
    const value = event.target.value;
    debounceSearchZone(value);
}

const debounceSearchZone = debounce((value) => {
    emit("searchZone", value);
}, 400);

function nextPage(event) {
    emit("loadingPage", event.page + 1);
}

function clearSearch() {
    nameZone.value = "";
    emit("searchZone", "");
}
const zonesDataComputed = computed(() => {
    if (!sortField.value) return props.zonesData;

    return [...props.zonesData].sort((a, b) => {
        let fieldA = a[sortField.value];
        let fieldB = b[sortField.value];

        // Comparación numérica o alfabética
        if (typeof fieldA === "string") {
            fieldA = fieldA.toLowerCase();
            fieldB = fieldB.toLowerCase();
        }

        if (fieldA < fieldB) return sortOrder.value === 1 ? -1 : 1;
        if (fieldA > fieldB) return sortOrder.value === 1 ? 1 : -1;
        return 0;
    });
});

const handleSort = (event) => {
    sortField.value = event.sortField;
    sortOrder.value = event.sortOrder;
};
</script>
