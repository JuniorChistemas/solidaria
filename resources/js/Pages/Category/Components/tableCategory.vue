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

        <!-- Paginación Detalle -->
        <template #paginatorstart>
            <span>
                Categorías {{ pagination.from }} a {{ pagination.to }} de
                {{ pagination.total }}
            </span>
        </template>

        <!-- Encabezado con Búsqueda -->
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
                    <Button label="Nuevo" @click="openCategoryModal" />
                </div>
            </div>
        </template>
  <Dialog v-model:visible="showModal" :header="editMode ? 'Editar Categoría' : 'Nueva Categoría'" :modal="true">
    <div class="p-4">
        <label class="block font-semibold mb-2">Nombre de la Categoría</label>
        <InputText v-model="newCategoryName" class="w-full p-2 border rounded" />
        <small v-if="errorMessage" class="text-red-500">{{ errorMessage }}</small>
    </div>
    <template #footer>
        <Button label="Cancelar" class="p-button-text" @click="showModal = false" />
        <Button :label="editMode ? 'Actualizar' : 'Guardar'" class="p-button-primary" @click="saveCategory" />
    </template>
</Dialog>
<Dialog v-model:visible="showDeleteModal" header="Confirmar Eliminación" :modal="true">
    <div class="p-4">
        <p>¿Estás seguro de que deseas eliminar la categoría <strong>{{ categoryToDelete?.name }}</strong>?</p>
    </div>
    <template #footer>
        <Button label="Cancelar" class="p-button-text" @click="showDeleteModal = false" />
        <Button label="Eliminar" class="p-button-danger" @click="deleteCategory" />
    </template>
</Dialog>
        <!-- Mensaje cuando no hay datos -->
        <template #empty>
            <h3>No existen categorías registradas</h3>
        </template>

        <!-- Columnas de la Tabla -->
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
    @click="openEditCategoryModal(slotProps.data)"
/>

                    <Button
    icon="pi pi-trash"
    outlined
    rounded
    class="p-button-sm"
    severity="danger"
    tooltip="Eliminar"
    @click="openDeleteDialog(slotProps.data)"
/>
                </div>
            </template>
        </Column>
    </DataTable>
</template>

<script setup>
import { ref,watch, defineProps, defineEmits } from "vue";
import Badge from "primevue/badge";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import axios from "axios";
import { debounce } from "lodash";

// Props del componente
const props = defineProps({
    categoriesData: Array,
    pagination: Object,
    loadingTable: Boolean
});

// Variables de estado
const nameCategory = ref("");
const newCategoryName = ref("");
const showModal = ref(false);
const errorMessage = ref("");
const editMode = ref(false);
const categoryId = ref(null);
const showDeleteModal = ref(false);
const categoryToDelete = ref(null);

// Emitir eventos
const emit = defineEmits(["loadingPage", "createCategory", "editCategory", "deleteCategory", "searchCategory"]);

// Abrir modal de nueva categoría
function openCategoryModal() {
    newCategoryName.value = "";
    categoryId.value = null; // Se limpia la ID para que no use la anterior
    editMode.value = false; // Se asegura que no está en modo edición
    errorMessage.value = "";
    showModal.value = true;
}

// Abrir modal en modo edición
function openEditCategoryModal(category) {
    newCategoryName.value = category.name;
    categoryId.value = category.id;
    editMode.value = true;
    errorMessage.value = "";
    showModal.value = true;
}

// Función para abrir el diálogo de confirmación
function openDeleteDialog(category) {
    categoryToDelete.value = category;
    showDeleteModal.value = true;
}

// Guardar o actualizar categoría
async function saveCategory() {
    if (!newCategoryName.value) {
        errorMessage.value = "El nombre de la categoría es obligatorio";
        return;
    }

    try {
        let response;
        if (editMode.value) {
            // Hacer una solicitud PUT para actualizar la categoría
            response = await axios.put(`/category/update/${categoryId.value}`, {
                name: newCategoryName.value
            });
        } else {
            // Hacer una solicitud POST para agregar una nueva categoría
            response = await axios.post(`/category/add`, {
                name: newCategoryName.value
            });
        }

        // Emitir evento para actualizar la lista de categorías
        emit("createCategory");

        // Cerrar modal y limpiar estado
        showModal.value = false;
        newCategoryName.value = "";
        categoryId.value = null;
        editMode.value = false;
    } catch (error) {
        if (error.response?.data?.error) {
            errorMessage.value = error.response.data.errors.name ? error.response.data.errors.name[0] : "Ocurrió un error inesperado";
        } else {
            errorMessage.value = "Ocurrió un error al guardar la categoría";
        }
    }
}



// Función para eliminar la categoría
async function deleteCategory() {
    if (!categoryToDelete.value) return;

    try {
        await axios.delete(`/category/delete/${categoryToDelete.value.id}`);

        // Emitir evento para actualizar la lista de categorías
        emit("deleteCategory");

        // Cerrar el modal
        showDeleteModal.value = false;
        categoryToDelete.value = null;
    } catch (error) {
        console.error("Error al eliminar la categoría:", error);
    }
}


// Búsqueda con debounce
const debounceSearchCategory = debounce((value) => {
    emit("searchCategory", value);
}, 400);
function handleSearchInput(event) {
    const value = event.target.value;
    debounceSearchCategory(value);
}

// Cambio de página
function nextPage(event) {
    console.log("Cambiando a la página:", event.page + 1); // Depuración en consola
    emit("loadingPage", event.page + 1); // PrimeVue usa índice basado en 0, sumamos 1 para Laravel
}

// Función para limpiar búsqueda
function clearSearch() {
    nameCategory.value = "";
    emit("searchCategory", ""); // Volver a cargar todas las categorías
}

</script>
