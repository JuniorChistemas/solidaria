<script setup>
import { ref, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TableCategorys from "./Components/tableCategory.vue";
import axios from "axios";

const categoriesData = ref([]);
const loadingTable = ref(true);
const pagination = ref({});

// Función para manejar cambio de página
const loadingPage = (page) => {
    console.log("Recibida la nueva página:", page);
    fetchCategories(page);
};

// Función para cargar las categorías con paginación
const fetchCategories = async (page = pagination.value.current_page || 1, name = "") => {
    loadingTable.value = true;
    try {
        console.log("Solicitando datos de la página:", page);
        const response = await axios.get(`/category/list?page=${page}&name=${name}`);
        
        categoriesData.value = response.data.data;
        pagination.value = response.data.pagination; // Mantener la paginación actualizada

        console.log("Datos recibidos:", response.data);
    } catch (error) {
        console.error("Error al cargar las categorías:", error);
    } finally {
        loadingTable.value = false;
    }
};

// Función para búsqueda
const searchCategory = (name) => {
    fetchCategories(1, name); // Siempre buscar desde la primera página
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
