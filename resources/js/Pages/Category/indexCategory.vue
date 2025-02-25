<script setup>
import { ref, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TableCategorys from "./Components/tableCategory.vue";
import axios from "axios";

const categoriesData = ref([]);
const loadingTable = ref(true);
const pagination = ref({
    total: 0,
    current_page: 1,
    per_page: 10,
    last_page: 1,
    from: 0,
    to: 0
});

const nameCategory = ref(""); // Mantener el valor de búsqueda

// Función para manejar cambio de página
const loadingPage = (page) => {
    console.log("Recibida la nueva página:", page);
    fetchCategories(page, nameCategory.value); // Pasar el término de búsqueda al cambiar de página
};

// Función para cargar las categorías con paginación y búsqueda
const fetchCategories = async (page = pagination.value.current_page, name = nameCategory.value) => {
    loadingTable.value = true;
    try {
        const response = await axios.get(`/category/list?page=${page}&name=${name}`);

        categoriesData.value = response.data.data || [];
        pagination.value = response.data.pagination || {
            total: 0,
            current_page: page,
            per_page: 10,
            last_page: 1,
            from: 0,
            to: 0
        };

        console.log("Datos recibidos:", response.data);
    } catch (error) {
        console.error("Error al cargar las categorías:", error);
    } finally {
        loadingTable.value = false;
    }
};

// Función para búsqueda
const searchCategory = (name) => {
    nameCategory.value = name; // Guardar el término de búsqueda
    fetchCategories(1, name); // Siempre buscar desde la primera página
};

// Función para eliminar una categoría y mantener el filtro de búsqueda
const deleteCategoryAndReload = () => {
    fetchCategories(1, nameCategory.value); // Recargar manteniendo el filtro
};

// Cargar categorías al montar el componente
onMounted(() => fetchCategories());

</script>
<template>
    <AppLayout title="Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categorías
            </h2>
        </template>

        <div class="p-4">
          <TableCategorys
                :categoriesData="categoriesData"
                :pagination="pagination"
                :loadingTable="loadingTable"
                @createCategory="fetchCategories"
                @editCategory="fetchCategories"
                @deleteCategory="fetchCategories"
                @searchCategory="searchCategory"
                @loadingPage="loadingPage" 

            />

        </div>
    </AppLayout>
</template>
