<template>
    <AppLayout title="Categorías">
            <Toast position="bottom-right" />

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
                @loadingPage="fetchCategories"
                @searchCategory="searchCategory"
                @open-create="openCreateModal"
                @open-edit="openEditModal"
                @open-delete="openDeleteModal"
            />

            <CreateCategory
                v-if="showCreateModal"
    :visible="showCreateModal"
    :category="selectedCategory"
    @save="handleCreateCategory"
    @update="handleUpdateCategory"
    @refreshList="fetchCategories" 
    @closeCreateModal="closeCreateModal"
            />

            <DeleteCategory
                v-if="showDeleteModal"
                :visible="showDeleteModal"
                :category="selectedCategory"
                @delete="handleDeleteCategory"
                @closeDeleteModal="closeDeleteModal"
            />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableCategorys from "./Components/TableCategory.vue";
import CreateCategory from "./Components/CreateCategory.vue";
import DeleteCategory from "./Components/DeleteCategory.vue";
import useCategories from "@/composables/useCategories";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
const toast = useToast();

const {
    categoriesData,
    loadingTable,
    pagination,
    showCreateModal,
    showDeleteModal,
    selectedCategory,
    fetchCategories,
    searchCategory,
    openCreateModal,
    openEditModal,
    openDeleteModal,
    closeCreateModal,
    closeDeleteModal,
    handleCreateCategory,
    handleUpdateCategory,
    handleDeleteCategory
} = useCategories(useToast()); 


</script>
