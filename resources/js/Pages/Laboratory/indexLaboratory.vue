<template>
    <AppLayout title="Laboratorios">
            <Toast position="bottom-right" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laboratorios
            </h2>
        </template>


        <div class="p-4">
            <TableLaboratories
                :laboratoriesData="laboratoriesData"
                :pagination="pagination"
                :loadingTable="loadingTable"
                @loadingPage="fetchLaboratories"
                @searchLaboratory="searchLaboratory"
                @open-create="openCreateModal"
                @open-edit="openEditModal"
                @open-delete="openDeleteModal"
            />

            <CreateLaboratory
                v-if="showCreateModal"
                :visible="showCreateModal"
                :laboratory="selectedLaboratory"
                @save="handleCreateLaboratory"
                @update="handleUpdateLaboratory"
                @refreshList="fetchLaboratories" 
                @closeCreateModal="closeCreateModal"
            />

            <DeleteLaboratory
                v-if="showDeleteModal"
                :visible="showDeleteModal"
                :laboratory="selectedLaboratory"
                @delete="handleDeleteLaboratory"
                @closeDeleteModal="closeDeleteModal"
            />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableLaboratories from "./Components/tableLaboratory.vue";
import CreateLaboratory from "./Components/createLaboratory.vue";
import DeleteLaboratory from "./Components/deleteLaboratory.vue";
import useLaboratories from "@/Composables/useLaboratories";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
const toast = useToast();

const {
    laboratoriesData,
    loadingTable,
    pagination,
    showCreateModal,
    showDeleteModal,
    selectedLaboratory,
    fetchLaboratories,
    searchLaboratory,
    openCreateModal,
    openEditModal,
    openDeleteModal,
    closeCreateModal,
    closeDeleteModal,
    handleCreateLaboratory,
    handleUpdateLaboratory,
    handleDeleteLaboratory
} = useLaboratories(useToast()); 


</script>
